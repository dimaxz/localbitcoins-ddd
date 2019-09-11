<?php


namespace Infrastructure\Adapters;


class FileAdapter
{

    protected $dir;

    /**
     * FileAdapter constructor.
     * @param $dir
     * @throws \Exception
     */
    public function __construct($dir)
    {

        if (!is_dir($dir)) {
            throw new \Exception("dir not exit");
        }

        $this->dir = $dir;
    }


    /**
     * @param array $data
     * @return int
     * @throws FileAdapterException
     */
    public function insert(array $data): int
    {
        $key = time();
        if (false === file_put_contents($this->dir . '/' . $key, serialize($data))) {
            throw new FileAdapterException("content not insert");
        }
        return $key;
    }

    /**
     * @param array $data
     * @param int $key
     * @throws FileAdapterException
     */
    public function update(array $data, int $key): void
    {

        if (false === file_put_contents($this->dir . '/' . $key, serialize($data))) {
            throw new FileAdapterException("content not update");
        }

    }

    /**
     * @param int $key
     * @throws FileAdapterException
     */
    public function delete(int $key): void
    {
        if (false === unlink($this->dir . '/' . $key)) {
            throw new FileAdapterException("content not delete");
        }
    }

    /**
     * @param int $key
     * @return array
     * @throws FileAdapterException
     */
    public function get(int $key): array
    {

        if (!$res = file_get_contents($this->dir . '/' . $key)) {
            throw new FileAdapterException("content not read");
        }

        return unserialize($res);
    }

    /**
     * @return array
     * @throws FileAdapterException
     */
    public function getAll(): array
    {
        $files = scandir($this->dir);
        $data = [];
        foreach ($files as $file) {
            if (!in_array($file, [".", ".."])) {
                $data[] = $this->get($file);
            }
        }

        return $data;
    }

}