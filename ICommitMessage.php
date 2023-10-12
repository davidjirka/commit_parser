<?php
    interface ICommitMessage {
        public function GetTitle() : string;
        public function GetTaskId() : ?int;
        public function GetTags() : array;
        public function GetDetails() : array;
        public function GetBCBreaks() : array;
        public function GetFeatures() : array;
        public function GetTodos() : array;
        public function GetString() : string;
    }
?>