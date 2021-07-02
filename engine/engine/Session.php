<?php


namespace app\engine;


class Session
{
    private string $session_id;
    private array $params = [];

    public function __construct()
    {
        $this->session_id = session_id();
        $this->params = $_SESSION;
        // есть ещё session_regenerate_id() и session_destroy(), не знаю, стоит ли сюда их вставлять
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->session_id;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setParam($name, $value): void
    {
        $_SESSION[$name] = $value;
    }


}
