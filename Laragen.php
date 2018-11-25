<?php

namespace Ewth;

class Laragen
{

    protected $types = [
        'int' => 'integer',
        'varchar' => 'string',
        'char' => 'char',
        'text' => 'string',
        ''
    ];
    protected $env = [];

    protected $table = '';

    protected $migration = [];

    /** @var \mysqli $mysqli */
    protected $mysqli;

    /**
     * Laragen constructor.
     *
     * @param string $envFile
     * @param int    $outputLevel
     *
     * @throws \Exception
     */
    public function __construct(
        $table,
        $envFile = '.env'
    ) {
        $this->loadEnv($envFile);
        if (strtolower($this->env('DB_CONNECTION')) !== 'mysql') {
            throw new \Exception('Only mysql is supported.');
        }
        $this->table  = $table;
        $this->mysqli = new \mysqli(
            $this->env('DB_HOST'),
            $this->env('DB_USERNAME'),
            $this->env('DB_PASSWORD'),
            $this->env('DB_DATABASE'),
            $this->env('DB_PORT')
        );

        if ($this->mysqli->connect_errno) {
            throw new \Exception('Could not connect to mysql');
        }
    }

    /*
     *         Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('employee_count')->nullable()->default(0);
            $table->integer('order_count')->nullable()->default(0);
            $table->decimal('total_spend', 18, 4)->nullable()->default(0);
            $table->tinyInteger('enabled')->default(1);
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
     */
    /**
     * Generate migration data for table.
     */
    public function generate()
    {
        $tableDetails = $this->mysqli->query('DESCRIBE ' . $this->table);
        while ($result = $tableDetails->fetch_object()) {
            if ($result->Extra === 'auto_increment') {
                $migration[] = '$table->increments(\'' . $result->Field . '\');';
            } elseif (preg_match('#([a-z]+)(\([0-9\,]+\))?( unsigned)?#', $result->Type ?? '', $matches)) {
                $type = 'string';
                $length = null;
                switch ($matches[1]) {
                    case 'int':
                        break;
                    case 'decimal':
                        $type = 'decimal';
                        if (isset($matches[2])) {
                            $length = $matches[2];
                        }
                        case ''
                }
            }
            echo "\n-----\n";
        }
    }

    /**
     * @param string $envFile
     *
     * @throws \Exception
     */
    protected function loadEnv($envFile = '.env')
    {
        if (!file_exists($envFile)) {
            throw new \Exception('File "' . $envFile . '" not found');
        }
        $data = explode("\n", file_get_contents('.env'));
        foreach ($data as $item) {
            if (preg_match('#([A-Z0-9\_]+)\=(.[^\n]+)#', $item, $matches)) {
                $this->env[trim($matches[1])] = trim($matches[2], " \t\n\r\0\x0B'\"");
            }
        }
    }

    /**
     * @param        $envKey
     * @param string $default
     *
     * @return mixed|string
     */
    protected function env($envKey, $default = '')
    {
        return isset($this->env[$envKey]) ? $this->env[$envKey] : $default;
    }

    /**
     * Close mysqli link on the way out.
     */
    public function __destruct()
    {
        if ($this->mysqli && !$this->mysqli->connect_errno) {
            $this->mysqli->close();
        }
    }
}

