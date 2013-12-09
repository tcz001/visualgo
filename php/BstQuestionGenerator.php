<?php
  require QuestionGeneratorInterface.php;
  require QuestionObject.php;
  require BST.php;
  require Constant.php;

  class BstQuestionGenerator implements QuestionGeneratorInterface{
    public function __construct(){
    }

    public function generateQuestion($amt){
      return array($this->generateSearchSequenceQuestion()); // Stub
    }

    public function checkAns($qObj,$userAns){
      if($qObj->qType == QUESTION_TYPE_SEARCH) return $this->checkSearchSequenceQuestion($qObj, $userAns);
    }

    protected function generateSearchSequenceQuestion(){
      $bst = new BST();
      $bst->insertRandomElements(5);
      $bstContent = $bst->getAllElements();
      $varToBeSearched = $bstContent[array_rand($bstContent)];

      $qObj = new QuestionObject();
      $qObj->qTopic = QUESTION_TOPIC_BST;
      $qObj->qType = QUESTION_TYPE_SEARCH;
      $qObj->qSubType = QUESTION_SUB_TYPE_NONE;
      $qObj->qParams = array("value" => $varToBeSearched);
      $qObj->aType = ANSWER_TYPE_VERTEX;
      $qObj->aAmt = ANSWER_AMT_MULTIPLE;
      $qObj->ordered = true;
      $qObj->allowNoAnswer = false;
      $qObj->graphState = $bst->toGraphState();
      $qObj->internalDS = $bst;

      return $qObj;
    }

    protected function checkSearchSequenceQuestion($qObj, $userAns){
      $bst = $qObj->internalDS;
      $varToBeSearched = $qObj->qParams["value"];
      $ans = $bst->search($varToBeSearched);

      return $ans === $userAns;
    }
  }
?>