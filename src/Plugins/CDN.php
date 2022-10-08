<?php

namespace duan617\Flysystem\QcloudCOSv5\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;
use Symfony\Component\Cache\Traits\FilesystemTrait;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Cdn\V20180606\CdnClient;
use TencentCloud\Cdn\V20180606\Models\PurgeUrlsCacheRequest;
use TencentCloud\Cdn\V20180606\Models\PushUrlsCacheRequest;
use TencentCloud\Cdn\V20180606\Models\PurgePathCacheRequest;
use TencentCloud\Cdn\V20180606\Models\DescribePushTasksRequest;
use TencentCloud\Cdn\V20180606\Models\DescribePurgeTasksRequest;
use TencentCloud\Cdn\V20180606\Models\DescribePurgeQuotaRequest;
use TencentCloud\Cdn\V20180606\Models\DescribePushQuotaRequest;

class CDN extends AbstractPlugin
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
        return 'cdn';
    }

    /**
     * @return $this
     */
    public function handle()
    {
        return $this;
    }

    /**
     * 刷新URL
     * @param array $url
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\PurgeUrlsCacheResponse|TencentCloudSDKException
     */
    public function refreshUrl(array $url)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new PurgeUrlsCacheRequest();

            $params = [
                'Action'  => 'PurgeUrlsCache',
                'Version' => '2018-06-06',
                'Urls'    => $url,
            ];
            $req->fromJsonString(json_encode($params));
            return $client->PurgeUrlsCache($req);
        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 预热URL
     * @param array $url
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\PushUrlsCacheResponse|TencentCloudSDKException
     */
    public function refreshOverseaUrl(array $url)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new PushUrlsCacheRequest();

            $params = [
                'Action'  => 'PushUrlsCache',
                'Version' => '2018-06-06',
                'Urls'    => $url,
            ];
            $req->fromJsonString(json_encode($params));
            return $client->PushUrlsCache($req);
        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 刷新目录
     * @param array $dir
     * @param string $flushType flush：刷新产生更新的资源 delete：刷新全部资源
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\PurgePathCacheResponse|TencentCloudSDKException
     */
    public function refreshDir(array $dir, string $flushType = 'delete')
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new PurgePathCacheRequest();

            $params = [
                'Action'    => 'PurgePathCache',
                'Version'   => '2018-06-06',
                'Paths'     => $dir,
                'FlushType' => $flushType,
            ];
            $req->fromJsonString(json_encode($params));
            return $client->PurgePathCache($req);
        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 查询预热历史
     * @param array $data
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\DescribePushTasksResponse|TencentCloudSDKException
     */
    public function describePushTasks(array $data)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new DescribePushTasksRequest();

            $req->fromJsonString(json_encode(array_merge($params, $data)));
            return $client->DescribePushTasks($req);

        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 查询刷新历史
     * @param array $data
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\DescribePurgeTasksResponse|TencentCloudSDKException
     */
    public function describePurgeTasks(array $data)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new DescribePurgeTasksRequest();

            $params = [
                'Action'  => 'PurgePathCache',
                'Version' => '2018-06-06',
            ];
            $req->fromJsonString(json_encode(array_merge($params, $data)));
            return $client->DescribePurgeTasks($req);

        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 查询预热用量
     * @param array $data
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\DescribePushQuotaResponse|TencentCloudSDKException
     */
    public function describePushQuota(array $data)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new DescribePushQuotaRequest();

            $params = [
                'Action'  => 'PurgePathCache',
                'Version' => '2018-06-06',
            ];
            $req->fromJsonString(json_encode(array_merge($params, $data)));
            return $client->DescribePushQuota($req);

        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

    /**
     * 查询刷新用量
     * @param array $data
     * @return \Exception|\TencentCloud\Cdn\V20180606\Models\DescribePurgeQuotaResponse|TencentCloudSDKException
     */
    public function describePurgeQuota(array $data)
    {
        try {
            $cred = new Credential($this->config['credentials']['secretId'], $this->config['credentials']['secretKey']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("cdn.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $client = new CdnClient($cred, "", $clientProfile);
            $req = new DescribePurgeQuotaRequest();

            $params = [
                'Action'  => 'PurgePathCache',
                'Version' => '2018-06-06',
            ];
            $req->fromJsonString(json_encode(array_merge($params, $data)));
            return $client->DescribePurgeQuota($req);

        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }

}
