<?php
class news extends controller{
    
    public $newsModel;
    public function __construct()
    {
        $this->newsModel = $this->model("newsModel");
    }
    function SayHi(){
        if(isset($_GET['page'])){
            $page = $_GET['page'] * 4;
        } else{
            $page = 4;
        }

        $this->view(
            "layout",
            [
            "Pages"=>"news",
            "AllNews"=>$this->newsModel->SelectAllNews($page),
            ],
        );
    }
    
    function details(){
        $this->view(
            "layout",
            [
            "Pages"=>"news-details",
            "NewsID"=> $this->newsModel->SelectNewsID($_GET['newsID']),
            ],
        );
    }
}

?>