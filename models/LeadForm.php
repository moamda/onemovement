<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LeadForm handles the landing page lead capture form.
 */
class LeadForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $business_type;
    public $message;

    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required'],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[0-9\+\-\s\(\)]{7,20}$/', 'message' => 'Enter a valid phone number.'],
            [['name', 'phone', 'business_type'], 'string', 'max' => 150],
            ['message', 'string', 'max' => 1000],
            [['name', 'email', 'phone', 'business_type', 'message'], 'trim'],
            [['name', 'email', 'phone', 'business_type', 'message'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'          => 'Full Name',
            'email'         => 'Email Address',
            'phone'         => 'Phone / Mobile Number',
            'business_type' => 'Type of Business',
            'message'       => 'Tell Us About Your Business',
        ];
    }

    public function sendLead($email)
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] ?? 'noreply@1okay.com' => '1Okay Services'])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject('New Website Inquiry from ' . $this->name . ' (' . $this->business_type . ')')
            ->setTextBody(
                "Name: {$this->name}\n"
                . "Email: {$this->email}\n"
                . "Phone: {$this->phone}\n"
                . "Business Type: {$this->business_type}\n\n"
                . "Message:\n{$this->message}"
            )
            ->send();
    }
}
