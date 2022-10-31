<?php
namespace App\Message;

use Exception;
use App\Helper\SmsHelper;

class SmsMessage
{
    protected array $lines;
    private string $to;

    public function to($to): SmsMessage
    {
        $this->to = $to;
        return $this;
    }

    public function line($line = ''): SmsMessage
    {
        $this->lines[] = $line;
        return $this;
    }

    public function send()
    {
        SmsHelper::send(['mobile' => $this->to, 'message' => collect($this->lines)->join("\n", "")]);
    }
}
