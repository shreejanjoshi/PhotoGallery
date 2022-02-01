<?php

class Paginate
{
    public $current_page;
    public $items_per_page;
    public $items_total_count;

    public function __construct($page=1, $items_per_page=4, $items_total_count=0){
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
    }

    public function next() {
        return $this->current_page + 1;
    }

    public function previous() {
        return $this->current_page - 1;
    }

    //how find out in index.php there is total count divided by iterm per page
    public function page_total() {
        //round up
        return ceil($this->items_total_count / $this->items_per_page);
    }

    //detect next page or previous page

    //if previous is bigger or equal to 1
    public function has_previous() {
        return $this->previous() >= 1 ? true : false;
    }

    //if smaller we know we have next page but bigger we dont have next page
    public function has_next() {
        return $this->next() <= $this->page_total() ? true : false;
    }

    public function offset() {
        //0*4
        return ($this->current_page - 1) * $this->items_per_page;
    }
}