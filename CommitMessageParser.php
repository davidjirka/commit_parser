<?php
require_once("ICommitMessageParser.php");
require_once("CommitMessage.php");
class CommitMessageParser implements ICommitMessageParser {
    private $message;    

    public function __construct() {}
    
    public function Parse(string $message) : ICommitMessage {
        $this->message = $message;
        return new CommitMessage($message);
    }
}
?>