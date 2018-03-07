<?php
namespace Auth0\SDK\Scaffold;

interface ApiTestInterface
{
    public function __construct();
    
    public function renderTitle();
    
    public function renderDataHeader();
    
    public function renderData();
    
    public function render();
}