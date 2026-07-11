<?php

namespace app\commands;

use Yii;
use DateTime;
use app\models\Member;
use app\models\Applicant;
use yii\console\Controller;
use yii\console\ExitCode;

class MemberController extends Controller
{
    /**
     * Usage:
     * php yii member/import-official-members
     */
    public function actionImport()
    {
        $file = Yii::getAlias('@app/data/0-1000.csv');

        if (!file_exists($file)) {
            $this->stderr("CSV file not found.\n");
            return ExitCode::NOINPUT;
        }

        $handle = fopen($file, 'r');

        if ($handle === false) {
            $this->stderr("Unable to open CSV file.\n");
            return ExitCode::IOERR;
        }

        $header = fgetcsv($handle);
        $header = array_map(function ($column) {
            return preg_replace('/^\xEF\xBB\xBF/', '', trim($column));
        }, $header);

        if (!$header) {
            fclose($handle);

            $this->stderr("Invalid CSV header.\n");

            return ExitCode::DATAERR;
        }

        /**
         * Error Log
         */
        $logFile = Yii::getAlias('@runtime/logs/member_import_errors.log');

        file_put_contents(
            $logFile,
            "========== MEMBER IMPORT ==========\n"
                . date('Y-m-d H:i:s')
                . "\n\n"
        );

        /**
         * Counters
         */
        $processed = 0;
        $success = 0;
        $failed = 0;

        $this->stdout("=========================================\n");
        $this->stdout(" Official Members Import Started\n");
        $this->stdout("=========================================\n\n");

        while (($data = fgetcsv($handle)) !== false) {

            $processed++;

            /**
             * Validate CSV columns
             */
            if (count($header) !== count($data)) {

                $failed++;

                file_put_contents(
                    $logFile,
                    "Row {$processed}\n"
                        . "Column count mismatch.\n"
                        . "Expected : " . count($header)
                        . "\nActual   : " . count($data)
                        . "\n------------------------------------------\n",
                    FILE_APPEND
                );

                continue;
            }

            $row = array_combine($header, $data);

            /**
             * One transaction per row
             */
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $row = array_map(function ($value) {
                    return is_string($value) ? trim($value) : $value;
                }, $row);

                $applicant = new Applicant();
                /**
                 * Auto map CSV columns
                 */
                foreach ($row as $column => $value) {

                    if ($applicant->hasAttribute($column)) {
                        if ($value === '') {
                            $value = null;
                        }

                        $applicant->$column = $value;
                    }
                }

                /**
                 * Force values
                 */
                $applicant->status = Applicant::STATUS_APPROVED;

                $applicant->document_verification_uplink_id = null;
                $applicant->document_verification_uplink_signature = null;

                /**
                 * Compute Age
                 */
                if (!empty($applicant->personal_information_birthday)) {

                    $birthday = new DateTime(
                        $applicant->personal_information_birthday
                    );

                    $today = new DateTime();

                    $applicant->personal_information_age =
                        $today->diff($birthday)->y;
                }

                /**
                 * Save Applicant
                 */
                if (!$applicant->save()) {

                    throw new \Exception(
                        "Applicant Validation Error\n"
                            . json_encode(
                                $applicant->getFirstErrors(),
                                JSON_UNESCAPED_UNICODE
                            )
                    );
                }

                /**
                 * Create Member
                 */
                $member = new Member();

                $member->applicant_id = $applicant->id;

                /**
                 * Alliance ID comes directly from the CSV.
                 * For INDIVIDUAL registrations, this will be NULL.
                 */
                $member->alliance_id = $applicant->volunteer_details_group_name;

                if (!$member->save()) {

                    throw new \Exception(
                        "Member Validation Error : "
                            . json_encode(
                                $member->getFirstErrors(),
                                JSON_UNESCAPED_UNICODE
                            )
                    );
                }

                /**
                 * ========
                 * PART 2
                 * ========
                 */

                $transaction->commit();

                $success++;

                if ($processed % 100 == 0) {

                    $this->stdout(
                        "Processed : {$processed} | Success : {$success} | Failed : {$failed}\n"
                    );
                }
            } catch (\Throwable $e) {

                $transaction->rollBack();

                $failed++;

                file_put_contents(
                    $logFile,
                    "Row {$processed}\n"
                        . $e->getMessage()
                        . "\n------------------------------------------\n",
                    FILE_APPEND
                );
            }
        }

        fclose($handle);

        $this->stdout("\n");
        $this->stdout("=========================================\n");
        $this->stdout(" Official Members Import Finished\n");
        $this->stdout("=========================================\n");
        $this->stdout("Processed : {$processed}\n");
        $this->stdout("Success   : {$success}\n");
        $this->stdout("Failed    : {$failed}\n");
        $this->stdout("Log File  : {$logFile}\n");

        return ExitCode::OK;
    }
}
