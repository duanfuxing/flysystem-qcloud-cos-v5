<?php

namespace duan617\Flysystem\QcloudCOSv5\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;
use Symfony\Component\Cache\Traits\FilesystemTrait;
use Qcloud\Cos\Exception\ServiceResponseException;

class ContentReview extends AbstractPlugin
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
        return 'contentReview';
    }

    /**
     * @return $this
     */
    public function handle()
    {
        return $this;
    }

    /**
     * 存量图片审核
     * @see https://cloud.tencent.com/document/product/436/61620
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function detectImage(array $params)
    {
        $config['Bucket'] = $this->config['bucket'];
        $config = array_merge($config, $params);

        try {
            return $this->client->detectImage($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 提交视频审核
     * @see https://cloud.tencent.com/document/product/436/47316
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function detectVideo(array $params)
    {
        $config['Bucket'] = $this->config['bucket'];
        $config = array_merge($config, $params);

        try {
            return $this->client->detectVideo($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 查询视频审核
     * @see https://cloud.tencent.com/document/product/436/47317
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getDetectVideoResult($key)
    {
        $config = [
            'Bucket' => $this->config['bucket'],
            'Key'    => $key,
        ];

        try {
            return $this->client->getDetectVideoResult($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 提交音频审核
     * @see https://cloud.tencent.com/document/product/436/54063
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function detectAudio(array $params)
    {
        $config['Bucket'] = $this->config['bucket'];
        $config = array_merge($config, $params);

        try {
            return $this->client->detectAudio($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 查询音频审核
     * @see https://cloud.tencent.com/document/product/436/54064
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getDetectAudioResult($key)
    {
        $config = [
            'Bucket' => $this->config['bucket'],
            'Key'    => $key,
        ];

        try {
            return $this->client->getDetectAudioResult($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 提交文档审核
     * @see https://cloud.tencent.com/document/product/436/59381
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function detectDocument(array $params)
    {
        $config['Bucket'] = $this->config['bucket'];
        $config = array_merge($config, $params);

        try {
            return $this->client->detectDocument($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 查询文档审核
     * @see https://cloud.tencent.com/document/product/436/59382
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function getDetectDocumentResult($key)
    {
        $config = [
            'Bucket' => $this->config['bucket'],
            'Key'    => $key,
        ];

        try {
            return $this->client->getDetectDocumentResult($config);
        } catch (ServiceResponseException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
