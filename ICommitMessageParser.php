<?php
include("ICommitMessage.php");
interface ICommitMessageParser {
    public function Parse(string $message) : ICommitMessage;
}
?>