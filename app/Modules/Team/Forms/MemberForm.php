<?php

namespace App\Modules\Team\Forms;

use Charlotte\Administration\Forms\AdminForm;

class MemberForm extends AdminForm {

    public function buildForm() {
        $this->add('name', 'text', [
            'title' => trans('team::admin.name'),
            'translate' => true
        ]);

        $this->add('position', 'text', [
            'title' => trans('team::admin.position'),
            'translate' => true
        ]);

        $this->add('active', 'switch', [
            'title' => trans('administration::admin.active')
        ]);

        $this->add('submit', 'button', [
            'title' => trans('administration::admin.submit')
        ]);
    }
}
