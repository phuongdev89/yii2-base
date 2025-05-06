<?php

namespace phuongdev89\base\actions;

use yii\base\Action;

class UserAjaxAction extends Action
{
    public $q;
    public $id;

    /**
     * This is the action to handle returning proper response
     * for select2 ajax request for User model.
     *
     * @return array the response
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => '',
            ],
        ];
        if (!is_null($this->q)) {
            $data = [];
            $users = User::find()->andWhere("username LIKE '%" . $this->q . "%' OR email LIKE '%" . $this->q . "%'")->limit(20)->all();
            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->id,
                    'text' => $user->username . ' - ' . $user->email,
                ];
            }
            $out['results'] = array_values($data);
        } elseif ($this->id > 0) {
            $out['results'] = [
                'id' => $this->id,
                'text' => User::findOne($this->id)->username,
            ];
        }
        return $out;

    }
}