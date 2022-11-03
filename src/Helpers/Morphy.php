<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 25.10.2022
 * Time: 01:52
 */

namespace SeoGenerator\Helpers;


class Morphy
{

    private $response;

    public function response()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }


    public function getCases(string $text, $plur = false)
    {
        $cases = [
            'nomn',
            'gent',
            'datv',
            'accs',
            'ablt',
            'loct',
            'voct',
        ];

        if ($plur) {
            $cases[] = plur;
        }
        $response = $this->process($text, $cases);
        if ($response !== true) {
            throw new \Exception($this->getError());
        }

        $res = $this->response();
        return $res['data'];
    }


    public function process($text, $cases)
    {
        $port = getenv('PYMORPHY2_PORT');
        $ip = getenv('PYMORPHY2_SERVER');
        $timeout_connect = 30;
        $timeout_response = 30;
        $link = "tcp://$ip:$port";
        if ($socket = @stream_socket_client($link, $errno, $errstr, $timeout_connect)) {
            $params = [
                'action' => 'phrase',
                'text' => $text,
                'cases' => $cases
            ];

            $data = json_encode($params);

            if (fwrite($socket, $data, strlen($data))) {
                stream_set_timeout($socket, $timeout_response);
                $response = stream_get_contents($socket);
                fclose($socket);

                if (!empty($response) && $response[0] == '{') {
                    $response = json_decode($response, true);
                    $this->setResponse($response);
                    if (!$response['success']) {
                        $this->setError($response['message']);
                        return false;
                    } else {
                        return true;
                    }
                }
            } else {
                fclose($socket);
                $this->setError("[Hoster] Could not write to {$ip}:{$port}");
                return false;
            }
        } else {
            $this->setError("[Hoster] Could not connect to {$ip}:{$port}: \"{$errstr}\".");
            return false;
        }
        return true;
    }


    public function setError($msg)
    {
        $this->msg = $msg;
    }

    public function getError()
    {
        return $this->msg;
    }

    public function isError()
    {
        return !empty($this->msg);
    }
}
