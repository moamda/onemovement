<?php

use yii\helpers\Html;

$this->title = 'Assign Activities';



?>

<?php

$activityListUrl = \yii\helpers\Url::to(['activity-lists']);

$assignUrl = \yii\helpers\Url::to(['assign-activity']);

$removeUrl = \yii\helpers\Url::to(['remove-activity']);

$this->registerJs("

function loadLists(){

    $.get('{$activityListUrl}',{

        id:$('#member-id').val()

    },function(res){

        $('#available-activities').empty();

        $.each(res.available,function(id,name){

            $('#available-activities').append(
                $('<option>',{
                    value:id,
                    text:name
                })
            );

        });

        $('#assigned-activities').empty();

        $.each(res.assigned,function(id,name){

            $('#assigned-activities').append(
                $('<option>',{
                    value:id,
                    text:name
                })
            );

        });

    });

}

loadLists();

/**
 * ==========================================
 * Assign Selected Activities
 * ==========================================
 *
 * Move selected activities from the
 * Available Activities list to the
 * Assigned Activities list.
 */
$('#btn-assign').click(function () {

    // Get selected activities from the Available list
    let ids = $('#available-activities').val();

    // Nothing selected
    if (!ids || ids.length === 0) {
        return;
    }

    // Counter to determine when all AJAX requests are finished
    let completed = 0;

    $.each(ids, function (i, id) {

        $.post('{$assignUrl}', {

            member_id: $('#member-id').val(),
            activity_id: id

        }, function () {

            completed++;

            /**
             * Refresh both lists only once after
             * all selected activities have been assigned.
             */
            if (completed === ids.length) {
                loadLists();
            }

        });

    });

});

/**
 * ==========================================
 * Remove Selected Activities
 * ==========================================
 *
 * Move selected activities from the
 * Assigned Activities list back to the
 * Available Activities list.
 */
$('#btn-remove').click(function () {

    // Get selected activities from the Assigned list
    let ids = $('#assigned-activities').val();

    // Nothing selected
    if (!ids || ids.length === 0) {
        return;
    }

    // Counter to determine when all AJAX requests are finished
    let completed = 0;

    $.each(ids, function (i, id) {

        $.post('{$removeUrl}', {

            member_id: $('#member-id').val(),
            activity_id: id

        }, function () {

            completed++;

            /**
             * Refresh both lists only once after
             * all selected activities have been removed.
             */
            if (completed === ids.length) {
                loadLists();
            }

        });

    });

});

");
?>

<div class="row">

    <div class="col-md-5">

        <h5>Available Activities</h5>

        <?= Html::listBox(
            'available',
            null,
            $availableActivities,
            [
                'id' => 'available-activities',
                'multiple' => true,
                'size' => 15,
                'class' => 'form-control',
            ]
        ) ?>

    </div>

    <div class="col-md-2 text-center" style="padding-top:120px;">

        <button
            id="btn-assign"
            class="btn btn-success btn-block">

            >>

        </button>

        <br>

        <button
            id="btn-remove"
            class="btn btn-danger btn-block">

            <<

                </button>

    </div>

    <div class="col-md-5">

        <h5>Assigned Activities</h5>

        <?= Html::listBox(
            'assigned',
            null,
            $assignedActivities,
            [
                'id' => 'assigned-activities',
                'multiple' => true,
                'size' => 15,
                'class' => 'form-control',
            ]
        ) ?>

    </div>

</div>

<input
    type="hidden"
    id="member-id"
    value="<?= $member->id ?>">