<?php

class ApiConnect
{

    private $data = array();

    private $response = array();

    private $error_message;

    public function sendRequest($url)
    {
        $request = wp_remote_get($url);

        if ($this->RequestHaveError($request)) {
            return false;
        }

        $this->response = $request;
        $this->setData(json_decode($this->response['body']));
        return true;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getData()
    {
        return $this->data;
    }

    private function setData($data)
    {
        $this->data = $data;
    }

    private function RequestHaveError($request)
    {
        if (is_wp_error($request)) {
            $this->error_message = $request->get_error_message();
            return true;
        }
        return false;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }
}