<?php
require_once("ICommitMessage.php");
class CommitMessage implements ICommitMessage {
    private $message;
    private $isFormatOfMessageOK = true;

    public function __construct($message) {
        $this->message = $message;
        $this->_IsFormatOfMessageOK();
    }

    // kontrola správnosti formátu logu
    private function _IsFormatOfMessageOK() { 
        preg_match_all("/\[[^]]+\] @.*#\d*\s.*\n\*/", $this->message, $first_row_details);
        if (!isset($first_row_details[0][0])) {
            $this->isFormatOfMessageOK = false;
        }        
        preg_match_all("/\* .*?\nBC:/", $this->message, $bc_after_details);
        if (!isset($bc_after_details[0][0])) {
            $this->isFormatOfMessageOK = false;
        }        
        preg_match_all("/BC: .*\nFeature/", $this->message, $feature_after_bc);
        if (!isset($feature_after_bc[0][0])) {
            $this->isFormatOfMessageOK = false;
        }        
        preg_match_all("/Feature: .*\nTODO/", $this->message, $todo_after_feature);
        if (!isset($todo_after_feature[0][0])) {
            $this->isFormatOfMessageOK = false;
        }        
    }

    // parsovací funkce 
    public function FormatSatus() : bool {
        return $this->isFormatOfMessageOK;
    }

    public function GetTitle() : string {                        
        preg_match("/#\d*\s(.*)/", $this->message, $title);                
        return $title[1];
    }
    public function GetTaskId() : ?int {        
        preg_match("/#(\d*)/", $this->message, $idNum);
        if ($idNum[1] >= 0) {
            return $idNum[1];
        } else {            
            return null;
        }
    }

    public function GetTags() : array {        
        preg_match_all("/\[([^]]+)\]/", $this->message, $tags);        
        return $tags[1];
    }

    public function GetDetails() : array {        
        preg_match_all("/\* (.*?)\n/", $this->message, $details);        
        return $details[1];
    }

    public function GetBCBreaks() : array {        
        preg_match_all("/BC: (.*)\n/", $this->message, $bc);        
        return $bc[1];
    }

    public function GetFeatures() : array {        
        preg_match_all("/Feature: (.*)\n/", $this->message, $features);        
        return $features[1];
    }

    public function GetTodos() : array {        
        preg_match_all("/TODO: (.*)/", $this->message, $todos);        
        return $todos[1];
    }
    
    public function GetString() : string {
        $tags = $this->GetTags();    
        $tag_str = "";
        foreach ($tags as $tag) {        
            $tag_str = $tag.", ";           
        }
        $details = $this->GetDetails();
        $details_str = "";
        foreach ($details as $detail) {        
            $details_str.$detail.", ";           
        }
        $bcs = $this->GetBCBreaks();
        $bcs_str = "";
        foreach ($bcs as $bc) {        
            $bcs_str.$bc.", ";           
        }
        $features = $this->GetFeatures();
        $features_str = "";
        foreach ($features as $feature) {        
            $features_str.$feature.", ";           
        }
        $todos = $this->GetTodos();
        $todos_str = "";
        foreach ($todos as $todo) {        
            $todos_str.$todo.", ";           
        }

        return "Title: ".$this->GetTitle().
                "Id: ".$this->GetTaskId().
                "Tags: ".$tag_str.
                "Details: ".$details_str.
                "BC: ".$bcs_str.
                "Features: ".$features_str.
                "Todos: ".$todos_str;
    }
}
?>