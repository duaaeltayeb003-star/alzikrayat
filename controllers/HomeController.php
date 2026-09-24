<?php
// controllers/HomeController.php

class HomeController extends Controller {
    /**
     * Show landing homepage
     */
    public function index(): void {
        $this->render('home');
    }

    /**
     * Show about us page
     */
    public function about(): void {
        $this->render('about');
    }
}