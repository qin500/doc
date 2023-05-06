<?php

class ClientDeviceInfo
{
    private $device_type;
    private $device_brand;
    private $device_model;

    private $browser_type;

    private $network;

    private $nt;

    public function __construct()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // 判断是否是移动设备
        if (preg_match('/(Android|iPhone|iPad|iPod|Windows Phone)/i', $user_agent)) {
            // 获取设备类型、品牌和型号
            if (preg_match('/iPhone/i', $user_agent)) {
                preg_match('/iPhone\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Apple';
            } elseif (preg_match('/iPad/i', $user_agent)) {
                preg_match('/iPad\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Apple';
            } elseif (preg_match('/Samsung/i', $user_agent)) {
                preg_match('/Samsung\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Samsung';
            } elseif (preg_match('/Xiaomi/i', $user_agent)) {
                preg_match('/Xiaomi\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Xiaomi';
            } elseif (preg_match('/Huawei/i', $user_agent)) {
                preg_match('/Huawei\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Huawei';
            } elseif (preg_match('/OPPO/i', $user_agent)) {
                preg_match('/OPPO\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'OPPO';
            } elseif (preg_match('/Vivo/i', $user_agent)) {
                preg_match('/Vivo\s([\w\s]+)/i', $user_agent, $matches);
                $this->device_model = isset($matches[1]) ? $matches[1] : 'Unknown';
                $this->device_brand = 'Vivo';
            } else {
                $this->device_model = 'Unknown';
                $this->device_brand = 'Unknown';
            }
            $this->device_type = '移动设备';
        } else {
            // 获取系统类型和操作系统信息
            if (preg_match('/Windows/i', $user_agent)) {
                $this->device_type = 'Windows';
                if (preg_match('/Windows NT 10.0/i', $user_agent)) {
                    $this->device_type = 'Windows 10';
                } elseif (preg_match('/Windows NT 6.3/i', $user_agent)) {
                    $this->device_type = 'Windows 8.1';
                } elseif (preg_match('/Windows NT 6.2/i', $user_agent)) {
                    $this->device_type = 'Windows 8';
                } elseif (preg_match('/Windows NT 6.1/i', $user_agent)) {
                    $this->device_type = 'Windows 7';
                } elseif (preg_match('/Windows NT 6.0/i', $user_agent)) {
                    $this->device_type = 'Windows Vista';
                } elseif (preg_match('/Windows NT 5.1/i', $user_agent)) {
                    $this->device_type = 'Windows XP';
                } else {
                    $this->device_type = 'Window Unknown';
                }
            } elseif (preg_match('/Macintosh/i', $user_agent)) {
                $this->device_type = 'Macintosh';
                if (preg_match('/Mac OS X/i', $user_agent)) {
                    preg_match('/Mac OS X (10[._]\d+)/i', $user_agent, $matches);
                    $this->device_type = isset($matches[1]) ? 'Mac OS X ' . str_replace('_', '.', $matches[1]) : 'Unknown';
                } else {
                    $this->device_type = 'Mac Unknown';
                }
            } elseif (preg_match('/Linux/i', $user_agent)) {
                $this->device_type = 'Linux';
            } else {
                $this->device_type = 'Unknown';
            }

        }


        // 获取浏览器类型
        if (preg_match('/MSIE|Trident/i', $user_agent)) {
            $this->browser_type = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $this->browser_type = 'Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $this->browser_type = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $this->browser_type = 'Safari';
        } elseif (preg_match('/Edg/i', $user_agent)) {
            $this->browser_type = "Edge";
        } else {
            $this->browser_type = 'Unknown';
        }

        // 获取联网方式
        if (preg_match('/(NetType\/|nt:)3g/i', $user_agent)) {
            $this->nt = '3g';
        } elseif (preg_match('/(NetType\/|nt:)4g/i', $user_agent)) {
            $this->nt = '4g';
        } elseif (preg_match('/(NetType\/|nt:)5g/i', $user_agent)) {
            $this->nt = '5g';
        } elseif (preg_match('/(NetType\/|nt:)wifi/i', $user_agent)) {
            $this->nt = 'wifi';
        } else {
            $this->nt = 'Unknown';
        }


// 获取联网方式
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->network = '代理服务器';
        } elseif (isset($_SERVER['HTTP_VIA'])) {
            $this->network = '网关';
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $this->network = '直接连接';
        } else {
            $this->network = '未知';
        }
    }

    public function getNetwork()
    {
        return $this->network;
    }

    public function getBrowerType()
    {
        return $this->browser_type;
    }

    public function getDeviceType()
    {
        return $this->device_type;
    }

    public function getDeviceBrand()
    {
        return $this->device_brand;
    }

    public function getDeviceModel()
    {
        return $this->device_model;
    }


    /**
     * @return array
     */
    public function getAll()
    {
        return [
            "device_type" => $this->device_type,
            "device_brand" => $this->device_brand,
            "device_model" => $this->device_model,
            "browser_type" => $this->browser_type,
            "network" => $this->network,
            "nt" => $this->nt,
            'ua' => $_SERVER['HTTP_USER_AGENT']
        ];
    }
}



