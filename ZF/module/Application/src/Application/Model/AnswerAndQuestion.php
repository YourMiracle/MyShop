<?php

namespace Application\Model;

class AnswerAndQuestion {

    public $id;
    public $nickname;
    public $question;
    public $answer;
    public $publish;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->question  = (!empty($data['question'])) ? $data['question'] : null;
        $this->answer  = (!empty($data['answer'])) ? $data['answer'] : null;
        $this->nickname = (!empty($data['nickname'])) ? $data['nickname'] : null;
        $this->publish = (!empty($data['publish'])) ? $data['publish'] : null;
    }
}