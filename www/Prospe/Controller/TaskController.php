<?php
/**
 * Date: 1/1/14
 */

namespace Prospe\Controller;

use Prospe\Helper\FacebookHelper;

class TaskController extends BaseController {

    protected $_task;

    public function beforeRoute($f3, $params) {
        parent::beforeRoute($f3, $params);
        // Check if the user is authenticated
        \Prospe\Helper\FacebookHelper::checkUser();
        // Check the user is accessing one of his tasks
        if (isset($params['task_id']) && !empty($params['task_id'])) {
            $task = new \Prospe\Model\TaskModel();
            $tasks = $task->find(array(
                'user_id=? and task_id=?', FacebookHelper::getUserId(), $params['task_id']
            ));
            if (count($tasks) !== 1) {
                $f3->error(403);
            } else {
                $this->_task = reset($tasks);
            }
        }
    }

    public function getAction($f3, $params) {
        $task = new \Prospe\Model\TaskModel();
        $tasks = $task->find(array(
            'user_id=?', FacebookHelper::getUserId()
        ));

        $f3->set('tasks', $tasks);
        echo \View::instance()->render('json/tasks/get.php');
    }

    public function progressAction($f3, $params) {
        $identifier = $params['task_id'];
        require_once('./vendors/AsyncTask.PHP/src/bootstrap.php');
        $asyncTask = \AsyncTask::get($identifier);
        $status = new \stdClass();
        $status->progress = $asyncTask->getProgress();
        $status->state = $asyncTask->getState();
        $f3->set('status', $status);
        echo \View::instance()->render('json/tasks/progress.php');
    }

}