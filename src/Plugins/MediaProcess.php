<?php

namespace Duan617\Flysystem\QcloudCOSv5\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;
use Symfony\Component\Cache\Traits\FilesystemTrait;
use Qcloud\Cos\Exception\ServiceResponseException;

class MediaProcess extends AbstractPlugin
{
    use FilesystemTrait;

    public $client;
    public $config;

    public function __construct($client, $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'mediaProcess';
    }

    /**
     * @return $this
     */
    public function handle()
    {
        return $this;
    }

    /**
     * 媒体截图
     * @param $key
     * @param $filePath
     * @param int $time
     * @return mixed
     * @throws \Exception
     */
    public function getSnapshot($key, $filePath, $time = 1)
    {
        try {
            return $this->client->getSnapshot([
                'Bucket'     => $this->config['bucket'],
                'Key'        => $key,
                'ci-process' => 'snapshot', // 操作类型，固定使用 snapshot
                'Time'       => $time, // 视频截帧时间点
                'SaveAs'     => $filePath, // 截图保存到本地的路径
            ]);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
