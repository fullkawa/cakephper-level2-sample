<?php
App::uses('AppHelper', 'View/Helper');
App::uses('User', 'Model');

class UsersIndexHelper extends AppHelper {

    public $helpers = array('Form');

    /**
     * "Delete"ボタン表示タグ(HTML)を取得する
     */
    public function getDeleteButton($user) {
        $html = '';
        $this->User = ClassRegistry::init('User');
        if ($this->User->isRegisted($user) === false) {
            $html = $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null,
                    __('Are you sure you want to delete # %s?', $user['User']['id']));
        }
        return $html;
    }
}
