<?php

namespace App\Message;

class CassandraMessage
{
    protected array $lines;
    private string $to;

    public function to($to): CassandraMessage
    {
        $this->to = $to;
        return $this;
    }

    public function line($line = ''): CassandraMessage
    {
        $this->lines[] = $line;
        return $this;
    }

    public function send()
    {
        //
    }
}
