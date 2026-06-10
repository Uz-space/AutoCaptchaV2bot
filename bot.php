<?php
error_reporting(0);

const class_version = "1.1.7";

// Warna teks (Telegramda ishlatilmaydi, lekin kodda qoladi)
const n = "\n";
const d = "\033[0m";
const m = "\033[1;31m";
const h = "\033[1;32m";
const k = "\033[1;33m";
const b = "\033[1;34m";
const u = "\033[1;35m";
const c = "\033[1;36m";
const p = "\033[1;37m";
const o = "\033[38;5;214m";
const o2 = "\033[01;38;5;208m";
const r = "\033[38;5;196m";
const g = "\033[38;5;46m";
const y = "\033[38;5;226m";
const b1 = "\033[38;5;21m";
const p1 = "\033[38;5;13m";
const c1 = "\033[38;5;51m";
const gr = "\033[38;5;240m";
const mp = "\033[101m\033[1;37m";
const hp = "\033[102m\033[1;30m";
const kp = "\033[103m\033[1;37m";
const bp = "\033[104m\033[1;37m";
const up = "\033[105m\033[1;37m";
const cp = "\033[106m\033[1;37m";
const pm = "\033[107m\033[1;31m";
const ph = "\033[107m\033[1;32m";
const pk = "\033[107m\033[1;33m";
const pb = "\033[107m\033[1;34m";
const pu = "\033[107m\033[1;35m";
const pc = "\033[107m\033[1;36m";
const yh = d."\033[43;30m";
const bg_r = "\033[48;5;196m";
const bg_g = "\033[48;5;46m";
const bg_y = "\033[48;5;226m";
const bg_b1 = "\033[48;5;21m";
const bg_p1 = "\033[48;5;13m";
const bg_c1 = "\033[48;5;51m";
const bg_gr = "\033[48;5;240m";

const LIST_YOUTUBE = [
        "https://youtu.be/lf1IpmCBGKU",
        "https://youtu.be/ZWBJ7unGjm8",
        "https://youtu.be/NlFhmw3DVvc",
        "https://youtu.be/a8PLbkNoj0E",
        "https://youtu.be/uCFB9J14GrI",
        "https://youtu.be/YnvE9JSoi-k",
        "https://youtu.be/XX4kVx-80Vw",
        "https://youtu.be/wfczg8pS9AA",
        "https://youtu.be/5S5jwy8Ulnw",
        "https://youtu.be/_mRSxm6a1OQ",
        "https://youtu.be/sgJecMF6ThI",
        "https://youtu.be/k1Lep8-9jig",
        "https://youtu.be/0gAY6vUdcRg",
        "https://youtu.be/uoP0GSveytM",
        "https://youtu.be/IF292mEvpvA",
        "https://youtu.be/x8FjgcCt3kc",
        "https://youtu.be/vOPgqGLx2gA"
];

// Telegram bot token
define('BOT_TOKEN', '8985212757:AAG3KeHlB7MpWAgKAcLubt7adPWhIz-PGJM');

Class Requests {
        static function Curl($url, $header=0, $post=0, $data_post=0, $cookie=0, $proxy=0, $skip=0){while(true){$ch = curl_init();curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);curl_setopt($ch, CURLOPT_COOKIE,TRUE);if($cookie){curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);}if($post) {curl_setopt($ch, CURLOPT_POST, true);}if($data_post) {curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);}if($header) {curl_setopt($ch, CURLOPT_HTTPHEADER, $header);}if($proxy){curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);curl_setopt($ch, CURLOPT_PROXY, $proxy);}curl_setopt($ch, CURLOPT_HEADER, true);$r = curl_exec($ch);if($skip){return;}$c = curl_getinfo($ch);if(!$c) return "Curl Error : ".curl_error($ch); else{$head = substr($r, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));$body = substr($r, curl_getinfo($ch, CURLINFO_HEADER_SIZE));curl_close($ch);if(!$body){print "Check your Connection!";sleep(2);print "\r                         \r";continue;}return array($head,$body);}}}
        static function get($url, $head =0){return self::curl($url,$head);}
        static function post($url, $head=0, $data_post=0){return self::curl($url,$head, 1, $data_post);}
        static function getXskip($url, $head =0){return self::curl($url,$head,'','','','',1);}
        static function postXskip($url, $head=0, $data_post=0){return self::curl($url,$head, 1, $data_post,'','',1);}
        static function getXcookie($url, $head=0, $cookie=0){if(!$cookie){$cookie ="cookie.txt";}return self::curl($url,$head,'','',$cookie);}
        static function postXcookie($url, $head=0, $data_post=0, $cookie=0){if(!$cookie){$cookie ="cookie.txt";}return self::curl($url,$head,1,$data_post,$cookie);}
        static function getXproxy($url, $head=0, $proxy){return self::curl($url,$head,'','',1,$proxy);}
        static function postXproxy($url, $head=0, $data_post, $proxy){return self::curl($url,$head,1,$data_post,1,$proxy);}
}

class Display {
        static function Clear(){}
        static function Menu($no, $title){return h."---[".p."$no".h."] ".k."$title\n";}
        static function Cetak($label, $msg = "[No Content]"){$len = 9;$lenstr = $len-strlen($label);return h."[".p.$label.h.str_repeat(" ",$lenstr)."]─> ".p.$msg.n;}
        static function Title($activitas){return bp.str_pad(strtoupper($activitas),45, " ", STR_PAD_BOTH).d.n;}
        static function Line($len = 45){return c.str_repeat('─',$len).n;}
        static function Ban($title, $versi, $server = 0){return "╔══════════════════════════════════════╗\n║         LITE PICK BOT v".versi."         ║\n╚══════════════════════════════════════╝\n";}
        static function ipApi(){return null;}
        static function Error($except){return m."---[".p."!".m."] ".p.$except;}
        static function Sukses($msg){return h."---[".p."✓".h."] ".p.$msg.n;}
        static function Isi($msg){return m."╭[".p."Input ".$msg.m."]".n.m."╰> ".h;}
}

class TelegramBot {
        private $token;
        
        public function __construct($token) {
                $this->token = $token;
        }
        
        public function sendMessage($chat_id, $text, $parse_mode = 'HTML') {
                $url = "https://api.telegram.org/bot{$this->token}/sendMessage";
                $data = [
                        'chat_id' => $chat_id,
                        'text' => $text,
                        'parse_mode' => $parse_mode
                ];
                
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                return json_decode($result, true);
        }
        
        public function getUpdates($offset = 0) {
                $url = "https://api.telegram.org/bot{$this->token}/getUpdates";
                $data = ['offset' => $offset, 'timeout' => 30];
                
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                return json_decode($result, true);
        }
}

class Functions {
        static function getUserConfigDir($user_id) {
                $dir = "users_config/" . $user_id . "/";
                if(!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                }
                return $dir . "config.json";
        }
        
        static function setConfig($user_id, $key, $value) {
                $configFile = self::getUserConfigDir($user_id);
                if(!file_exists($configFile)) {
                        $config = [];
                } else {
                        $config = json_decode(file_get_contents($configFile), 1);
                }
                $config[$key] = $value;
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
                return $value;
        }
        
        static function getConfig($user_id, $key) {
                $configFile = self::getUserConfigDir($user_id);
                if(!file_exists($configFile)) {
                        return null;
                }
                $config = json_decode(file_get_contents($configFile), 1);
                return isset($config[$key]) ? $config[$key] : null;
        }
        
        static function removeConfig($user_id, $key) {
                $configFile = self::getUserConfigDir($user_id);
                if(!file_exists($configFile)) return;
                $config = json_decode(file_get_contents($configFile), 1);
                unset($config[$key]);
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
        }
        
        static function getAllConfig($user_id) {
                $configFile = self::getUserConfigDir($user_id);
                if(!file_exists($configFile)) {
                        return [];
                }
                return json_decode(file_get_contents($configFile), 1);
        }
        
        static function view($youtube){return 0;}
        static function cfDecodeEmail($encodedString){$k = hexdec(substr($encodedString,0,2));for($i=2,$email='';$i<strlen($encodedString)-1;$i+=2){$email.=chr(hexdec(substr($encodedString,$i,2))^$k);}return $email;}
}

class HtmlScrap {
        function __construct(){
                $this->captcha = '/class=["\']([^"\']+)["\'][^>]*data-sitekey=["\']([^"\']+)["\'][^>]*>/i';
                $this->input = '/<input[^>]*name=["\'](.*?)["\'][^>]*value=["\'](.*?)["\'][^>]*>/i';
                $this->limit = '/(\d{1,})\/(\d{1,})/';
        }
        private function scrap($pattern, $html){preg_match_all($pattern, $html, $matches);return $matches;}
        private function getCaptcha($html){$scrap = $this->scrap($this->captcha, $html);for($i = 0; $i < count($scrap[1]); $i++){$data[$scrap[1][$i]] = $scrap[2][$i];}return $data;}
        private function getInput($html, $form = 1){$form = explode('<form', $html)[$form];$scrap = $this->scrap($this->input, $form);for($i = 0; $i < count($scrap[1]); $i++){$data[$scrap[1][$i]] = $scrap[2][$i];}return $data;}
        public function Result($html, $form = 1)
        {
                $data['title'] = explode('</title>',explode('<title>', $html)[1])[0];
                $data['cloudflare']=(preg_match('/Just a moment.../',$html))? true:false;
                $data['firewall'] =(preg_match('/Firewall/',$html))? true:false;
                $data['locked'] = (preg_match('/Locked/',$html))? true:false;
                $data["captcha"] = $this->getCaptcha($html);

                $input = $this->getInput($html, $form);
                $data["input"] = ($input)? $input:$this->getInput($html, 2);
                $data["faucet"] = $this->scrap($this->limit, $html);

                $sukses = explode("icon: 'success',",$html)[1];
                if($sukses){
                        $data["response"]["success"] = strip_tags(explode("'",explode("html: '",$sukses)[1])[0]);
                }else{
                        $warning = explode("'",explode("html: '",$html)[1])[0];
                        $ban = explode('</div>',explode('<div class="alert text-center alert-danger"><i class="fas fa-exclamation-circle"></i> Your account',$html)[1])[0];
                        $invalid = (preg_match('/invalid amount/',$html))? "You are sending an invalid amount":false;
                        $shortlink = (preg_match('/Shortlink in order to claim from the faucet!/',$html))? $warning:false;
                        $sufficient = (preg_match('/sufficient funds/',$html))? "Sufficient funds":false;
                        $daily = (preg_match('/Daily claim limit/',$html))? "Daily claim limit":false;
                        $data["response"]["unset"] = false;
                        $data["response"]["exit"] = false;
                        if($ban){
                                $data["response"]["warning"] = $ban;
                                $data["response"]["exit"] = true;
                        }elseif($invalid){
                                $data["response"]["warning"] = $invalid;
                                $data["response"]["unset"] = true;
                        }elseif($shortlink){
                                $data["response"]["warning"] = $shortlink;
                                $data["response"]["exit"] = true;
                        }elseif($sufficient){
                                $data["response"]["warning"] = $sufficient;
                                $data["response"]["unset"] = true;
                        }elseif($warning){
                                $data["response"]["warning"] = $warning;
                        }else{
                                $data["response"]["warning"] = "Not Found";
                        }
                }
                return $data;
        }
}

class Captcha {
        private $url,$key,$provider, $function, $user_id;
        public function __construct($user_id){
                $this->user_id = $user_id;
                if(empty(Functions::getConfig($user_id, 'type'))){
                        Functions::setConfig($user_id, "type", 2);
                }
                if(Functions::getConfig($user_id, "type") == 1){
            $this->url = 'http://api.multibot.in/';
                        $this->key = Functions::getConfig($user_id, "multibot_apikey");
                        $this->provider = "Multibot";
                        Functions::setConfig($user_id, "provider", "Multibot");
        }
        else{
            $this->url = 'https://sctg.xyz/';
                        $xevil_key = Functions::getConfig($user_id, "xevil_apikey");
                        $this->key = $xevil_key . "|SOFTID1204538927";
                        $this->provider = "Xevil";
                        Functions::setConfig($user_id, "provider", "Xevil");
        }
        }
        private function in_api($content, $method, $header = 0){$param = "key=".$this->key."&json=1&".$content;if($method == "GET")return json_decode(file_get_contents($this->url.'in.php?'.$param),1);$opts['http']['method'] = $method;if($header) $opts['http']['header'] = $header;$opts['http']['content'] = $param;return file_get_contents($this->url.'in.php', false, stream_context_create($opts));}
        private function res_api($api_id){$params = "?key=".$this->key."&action=get&id=".$api_id."&json=1";return json_decode(file_get_contents($this->url."res.php".$params),1);}
        private function solvingProgress($xr,$tmr, $cap){if($xr < 50){$wr=h;}elseif($xr >= 50 && $xr < 80){$wr=k;}else{$wr=m;}$xwr = [$wr,p,$wr,p];$sym = [' ─ ',' / ',' │ ',' \ ',];$a = 0;for($i=$tmr*4;$i>0;$i--){if($xr < 99)$xr+=1;$a++;}return $xr;}
        private function getResult($data ,$method, $header = 0){$cap = $this->filter(explode('&',explode("method=",$data)[1])[0]);$get_res = $this->in_api($data ,$method, $header);if(is_array($get_res)){$get_in = $get_res;}else{$get_in = json_decode($get_res,1);}if(!$get_in["status"]){$msg = $get_in["request"];if($msg){return 0;}elseif($get_res){return 0;}else{return 0;}}$a = 0;while(true){$get_res = $this->res_api($get_in["request"]);if($get_res["request"] == "CAPCHA_NOT_READY"){$ran = rand(5,10);$a+=$ran;if($a>99)$a=99;$a = $this->solvingProgress($a,5, $cap);continue;}if($get_res["status"]){return $get_res["request"];}return 0;}}
        private function filter($method){if($method == "userrecaptcha")return "RecaptchaV2";if($method == "hcaptcha")return "Hcaptcha";if($method == "turnstile")return "Turnstile";if($method == "universal" || $method == "base64")return "Ocr";if($method == "antibot")return "Antibot";if($method == "authkong")return "Authkong";if($method == "teaserfast")return "Teaserfast";}

        public function getBalance(){if(empty($this->key)) return "Key not set";$res = json_decode(file_get_contents($this->url."res.php?action=userinfo&key=".$this->key),1);return isset($res["balance"]) ? $res["balance"] : 0;}
        public function Turnstile($sitekey, $pageurl){$data = http_build_query(["method" => "turnstile","sitekey" => $sitekey,"pageurl" => $pageurl]);return $this->getResult($data, "GET");}
}

class Cloudflare {
        function __construct(){
                $this->python = "aW1wb3J0IG9zLCBzeXMsIHRpbWUsIGpzb24KZnJvbSBzZWxlZHJvaWQgaW1wb3J0IHdlYmRyaXZlcgpmcm9tIHNlbGVkcm9pZC53ZWJkcml2ZXIuY29tbW9uLmJ5IGltcG9ydCBCeQoKZHJpdmVyID0gd2ViZHJpdmVyLkNocm9tZShndWk9RmFsc2UpCmhvc3QgPSBzeXMuYXJndlsxXQoKZGVmIENsb3VkZmxhcmUoKToKCXRpdGxlID0gZHJpdmVyLnRpdGxlCglpZiBhbnkoc3ViLmxvd2VyKCkgaW4gdGl0bGUubG93ZXIoKSBmb3Igc3ViIGluIFsiY2xvdWRmbGFyZSIsImp1c3QgYSBtb21lbnQuLi4iXSk6CgkJdGltZS5zbGVlcCgxMCkKCQlyZXR1cm4gRmFsc2UKCWVsc2U6CgkJcmV0dXJuIFRydWUKCnRyeToKCWRyaXZlci5nZXQoaG9zdCkKCXdoaWxlIG5vdCBDbG91ZGZsYXJlKCk6CgkJdGltZS5zbGVlcCgzKQoJCgljZl9jbGVhcmFuY2UgPSBkcml2ZXIuZ2V0X2Nvb2tpZSgiY2ZfY2xlYXJhbmNlIikKCXVzZXJfYWdlbnQgPSBkcml2ZXIudXNlcl9hZ2VudApleGNlcHQgRXhjZXB0aW9uIGFzIGU6CglwcmludChmIntlfSIpCmZpbmFsbHk6Cgl0aXRsZSA9IGRyaXZlci50aXRsZQoJaWYgYW55KHN1Yi5sb3dlcigpIGluIHRpdGxlLmxvd2VyKCkgZm9yIHN1YiBpbiBbImNsb3VkZmxhcmUiLCJqdXN0IGEgbW9tZW50Li4uIl0pOwoJCWRhdGEgPSB7CgkJImNmX2NsZWFyYW5jZSIgOiBGYWxzZSwKCQkidXNlci1hZ2VudCIgOiB1c2VyX2FnZW50CgkJfQoJZWxzZToKCQlkYXRhID0gewoJCSJjZl9jbGVhcmFuY2UiIDogY2ZfY2xlYXJhbmNlLnNwbGl0KCI9IilbMV0sCgkJInVzZXItYWdlbnQiIDogdXNlcl9hZ2VudAoJCX0KCXdpdGggb3BlbignY2YuanNvbicsICd3JykgYXMgZmlsZToKCQlqc29uLmR1bXAoZGF0YSwgZmlsZSwgaW5kZW50PTQpCglkcml2ZXIuY2xvc2UoKQo=";
                $this->JsonFile = "cf.json";
                $this->pythonFile = "cf.py";
                $this->bypassFile = "cf.json";
        }
        public function BypassCf($host, $user_id){
                $file = file_put_contents($this->pythonFile,base64_decode($this->python));
                sleep(2);
                system("python {$this->pythonFile} ".$host);
                sleep(2);
                unlink($this->pythonFile);
                return $this->editConfig($user_id);
        }
        private function editConfig($user_id){
                $new_data = json_decode(file_get_contents($this->bypassFile),1);
                $new_cf_clearance = $new_data["cf_clearance"];
                unlink($this->bypassFile);
                $cookie = Functions::getConfig($user_id, "cookie");
                $cf_clearance_ori = explode(";",explode("cf_clearance=", $cookie)[1])[0];
                $data["cookie"] = str_replace($cf_clearance_ori, $new_cf_clearance, $cookie);
                $data["user-agent"] = $new_data["user-agent"];
                return $data;
        }
}

const
title = "LITEPICK",
versi = "1.0.8",
class_require = "1.1.7",
host = "https://litepick.io/",
turnstile = "0x4AAAAAAA0-UWDHOKP0OrgS";

if(class_version < class_require){
    die("Versi class sudah kadaluarsa");
}

class Bot {
        private $telegram;
        private $user_id;
        private $cookie;
        private $uagent;
        private $is_running = [];
        private $current_action = [];
        
        public function __construct($telegram, $user_id) {
                $this->telegram = $telegram;
                $this->user_id = $user_id;
                $this->is_running[$user_id] = false;
                
                $this->loadConfig();
                $this->sendMenu();
        }
        
        private function sendMenu() {
                $menu = "🤖 <b>LITEPICK BOT</b> v" . versi . "\n\n";
                $menu .= "📋 <b>Menu:</b>\n";
                $menu .= "1️⃣ /start - Botni qayta ishga tushirish\n";
                $menu .= "💰 /balance - Balansni ko'rish\n";
                $menu .= "🎁 /bonus - Bonus olish\n";
                $menu .= "⏰ /hourly - Hourly Bonus (avtomatik)\n";
                $menu .= "⚙️ /set_cookie - Cookie sozlash\n";
                $menu .= "🔑 /set_xevil - Xevil API key sozlash\n";
                $menu .= "🛑 /stop - Jarayonni to'xtatish\n\n";
                $menu .= "💡 <i>Har bir foydalanuvchi o'z sozlamalariga ega</i>";
                
                $this->telegram->sendMessage($this->user_id, $menu);
        }
        
        private function loadConfig() {
                $this->cookie = Functions::getConfig($this->user_id, "cookie");
                $this->uagent = Functions::getConfig($this->user_id, "user_agent");
                if(empty($this->uagent)) {
                        $this->uagent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36";
                        Functions::setConfig($this->user_id, "user_agent", $this->uagent);
                }
        }
        
        private function headers(){
                $h[] = "Host: ".parse_url(host)['host'];
                $h[] = "cookie: ".$this->cookie;
                $h[] = "X-Requested-With: XMLHttpRequest";
                $h[] = "user-agent: ".$this->uagent;
                return $h;
        }
        
        private function getDashboard() {
                $this->loadConfig();
                if(empty($this->cookie)) return ['error' => 'no_cookie'];
                
                $r = Requests::get(host, $this->headers());
                if(!$r) return ['error' => 'connection'];
                
                $html = $r[1];
                if(preg_match('/Just a moment.../', $html)) return ['cloudflare' => true];
                
                if(!preg_match('/login_button/', $html)) {
                        $data['Login'] = 1;
                        $data['Username'] = trim(explode('&',explode('&username=',$html)[1])[0]);
                        $data['Balance'] = explode('<',explode('class="drop_down_header_text user_balance">',$html)[1])[0];
                        return $data;
                }
                return ['error' => 'invalid_cookie'];
        }
        
        public function handleCommand($text) {
                $text = trim($text);
                
                if($text == '/start') {
                        $this->is_running[$this->user_id] = false;
                        $this->current_action[$this->user_id] = null;
                        $this->sendMenu();
                        return;
                }
                
                if($text == '/stop') {
                        $this->is_running[$this->user_id] = false;
                        $this->current_action[$this->user_id] = null;
                        $this->telegram->sendMessage($this->user_id, "⏹️ Bot to'xtatildi.");
                        return;
                }
                
                if($text == '/balance') {
                        $this->showBalance();
                        return;
                }
                
                if($text == '/bonus') {
                        if($this->is_running[$this->user_id]) {
                                $this->telegram->sendMessage($this->user_id, "⚠️ Bot allaqachon ishlamoqda. Avval /stop bosing.");
                                return;
                        }
                        $this->current_action[$this->user_id] = 'bonus';
                        $this->claimBonus();
                        return;
                }
                
                if($text == '/hourly') {
                        if($this->is_running[$this->user_id]) {
                                $this->telegram->sendMessage($this->user_id, "⚠️ Bot allaqachon ishlamoqda. Avval /stop bosing.");
                                return;
                        }
                        $this->current_action[$this->user_id] = 'hourly';
                        $this->hourlyFaucet();
                        return;
                }
                
                if($text == '/set_cookie') {
                        $this->telegram->sendMessage($this->user_id, "🍪 Cookie ni kiriting:\n\n(Bir daqiqa ichida cookie sozlanadi)");
                        $this->waitingForCookie = true;
                        return;
                }
                
                if($text == '/set_xevil') {
                        $this->telegram->sendMessage($this->user_id, "🔑 Xevil API key ni kiriting:\n\n(Bir daqiqa ichida sozlanadi)\n\nIewil bot: @Xevil_check_bot?start=1204538927");
                        $this->waitingForXevil = true;
                        return;
                }
                
                // Cookie kiritish
                if(isset($this->waitingForCookie) && $this->waitingForCookie) {
                        $this->waitingForCookie = false;
                        Functions::setConfig($this->user_id, "cookie", $text);
                        $this->loadConfig();
                        $this->telegram->sendMessage($this->user_id, "✅ Cookie muvaffaqiyatli saqlandi!");
                        $this->sendMenu();
                        return;
                }
                
                // Xevil key kiritish
                if(isset($this->waitingForXevil) && $this->waitingForXevil) {
                        $this->waitingForXevil = false;
                        Functions::setConfig($this->user_id, "xevil_apikey", $text);
                        $this->telegram->sendMessage($this->user_id, "✅ Xevil API key muvaffaqiyatli saqlandi!");
                        $this->sendMenu();
                        return;
                }
        }
        
        private function showBalance() {
                $this->loadConfig();
                
                if(empty($this->cookie)) {
                        $this->telegram->sendMessage($this->user_id, "❌ Cookie sozlanmagan. /set_cookie buyrug'i bilan sozlang.");
                        return;
                }
                
                $r = $this->getDashboard();
                
                if(isset($r['error'])) {
                        if($r['error'] == 'no_cookie') {
                                $this->telegram->sendMessage($this->user_id, "❌ Cookie sozlanmagan!");
                        } elseif($r['error'] == 'invalid_cookie') {
                                $this->telegram->sendMessage($this->user_id, "❌ Cookie eskirgan yoki noto'g'ri. /set_cookie bilan yangilang.");
                        } else {
                                $this->telegram->sendMessage($this->user_id, "❌ Ulanishda xatolik!");
                        }
                        return;
                }
                
                if(isset($r['cloudflare'])) {
                        $this->telegram->sendMessage($this->user_id, "🛡️ Cloudflare aniqlandi. Iltimos, birozdan keyin qayta urinib ko'ring.");
                        return;
                }
                
                $captcha = new Captcha($this->user_id);
                $balance = $captcha->getBalance();
                
                $msg = "💰 <b>BALANS MA'LUMOTLARI</b>\n\n";
                $msg .= "👤 Username: <code>" . $r['Username'] . "</code>\n";
                $msg .= "💎 Balance: <code>" . $r['Balance'] . "</code>\n";
                $msg .= "🔑 Xevil Balance: <code>" . ($balance ?: "0") . "</code>\n";
                
                $this->telegram->sendMessage($this->user_id, $msg);
        }
        
        private function claimBonus() {
                $this->loadConfig();
                
                if(empty($this->cookie)) {
                        $this->telegram->sendMessage($this->user_id, "❌ Cookie sozlanmagan. /set_cookie buyrug'i bilan sozlang.");
                        return;
                }
                
                $this->is_running[$this->user_id] = true;
                $n = 1;
                $msg = "🎁 <b>BONUS YIG'ISH BOSHLANDI</b>\n\n";
                $this->telegram->sendMessage($this->user_id, $msg);
                
                while($this->is_running[$this->user_id] && $n <= 50) {
                        $r = Requests::get(host.'faucet.php', $this->headers());
                        if(!$r) {
                                $this->telegram->sendMessage($this->user_id, "❌ Ulanishda xatolik!");
                                break;
                        }
                        
                        $html = $r[1];
                        
                        $bonus = (int)explode('</span>',explode('<span id="free_spins">',$html)[1])[0];
                        if($bonus < 1){
                                $this->telegram->sendMessage($this->user_id, "❌ Bonus spinlar mavjud emas!");
                                break;
                        }
                        
                        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $r[0], $matches);
                        $cookies = array();
                        foreach($matches[1] as $item) {
                                parse_str($item, $cookie);
                                $cookies = array_merge($cookies, $cookie);
                        }
                        
                        $data = "action=claim_bonus_faucet&csrf_test_name=".$cookies['csrf_cookie_name'];
                        $res = json_decode(Requests::post(host.'process.php',$this->headers(),$data)[1],1);
                        
                        if($res["ret"]){
                                $msg = "✅ <b>Bonus #{$n}</b>\n";
                                $msg .= "🎲 Number: {$res['num']}\n";
                                $msg .= "💬 {$res['mes']}\n";
                                $this->telegram->sendMessage($this->user_id, $msg);
                                $n++;
                        } else {
                                $this->telegram->sendMessage($this->user_id, "❌ Bonus olishda xatolik: " . ($res['mes'] ?? 'Noma\'lum'));
                                break;
                        }
                        sleep(2);
                }
                
                $this->is_running[$this->user_id] = false;
                $this->telegram->sendMessage($this->user_id, "🏁 Bonus yig'ish tugadi! Jami: " . ($n-1) . " marta");
        }
        
        private function hourlyFaucet() {
                $this->loadConfig();
                
                if(empty($this->cookie)) {
                        $this->telegram->sendMessage($this->user_id, "❌ Cookie sozlanmagan. /set_cookie buyrug'i bilan sozlang.");
                        return;
                }
                
                $xevil_key = Functions::getConfig($this->user_id, "xevil_apikey");
                if(empty($xevil_key)) {
                        $this->telegram->sendMessage($this->user_id, "❌ Xevil API key sozlanmagan. /set_xevil buyrug'i bilan sozlang.");
                        return;
                }
                
                $this->is_running[$this->user_id] = true;
                $n = 1;
                $msg = "⏰ <b>HOURLY BONUS BOSHLANDI</b>\n\nHar 1 soatda avtomatik yig'iladi";
                $this->telegram->sendMessage($this->user_id, $msg);
                
                while($this->is_running[$this->user_id]) {
                        $r = Requests::get(host.'faucet.php', $this->headers());
                        if(!$r) {
                                $this->telegram->sendMessage($this->user_id, "❌ Ulanishda xatolik!");
                                sleep(60);
                                continue;
                        }
                        
                        $html = $r[1];
                        
                        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $r[0], $matches);
                        $cookies = array();
                        foreach($matches[1] as $item) {
                                parse_str($item, $cookie);
                                $cookies = array_merge($cookies, $cookie);
                        }
                        
                        $captcha = new Captcha($this->user_id);
                        $cap = $captcha->Turnstile(turnstile, host.'faucet.php');
                        
                        if(!$cap) {
                                $this->telegram->sendMessage($this->user_id, "❌ Turnstile captcha yechilmadi!");
                                sleep(60);
                                continue;
                        }
                        
                        $data = 'action=claim_hourly_faucet&clbt=1&g-recaptcha-response=null&h-captcha-response=null&c_captcha_response='.$cap.'&csrf_test_name='.$cookies['csrf_cookie_name'];
                        
                        $res_raw = Requests::post(host.'process.php',$this->headers(),$data)[1];
                        $res = json_decode($res_raw, 1);
                        
                        if($res["ret"]){
                                $dash = $this->getDashboard();
                                $msg = "✅ <b>Hourly Claim #{$n}</b>\n";
                                $msg .= "🎲 Number: {$res['num']}\n";
                                $msg .= "💬 {$res['mes']}\n";
                                if(isset($dash['Balance'])) $msg .= "💰 Balance: {$dash['Balance']}\n";
                                $this->telegram->sendMessage($this->user_id, $msg);
                                $n++;
                        } else {
                                $this->telegram->sendMessage($this->user_id, "⚠️ " . ($res['mes'] ?? 'Noma\'lum xatolik'));
                        }
                        
                        // 1 soat kutish
                        for($i = 3600; $i > 0 && $this->is_running[$this->user_id]; $i -= 60) {
                                sleep(60);
                        }
                }
                
                $this->telegram->sendMessage($this->user_id, "🏁 Hourly bonus to'xtatildi! Jami: " . ($n-1) . " marta");
        }
}

// User session management
class BotManager {
        private $telegram;
        private $bots = [];
        private $waitingStates = [];
        
        public function __construct($telegram) {
                $this->telegram = $telegram;
        }
        
        public function handleUpdate($update) {
                $chat_id = $update['message']['chat']['id'];
                $text = $update['message']['text'] ?? '';
                
                if(!isset($this->bots[$chat_id])) {
                        $this->bots[$chat_id] = new Bot($this->telegram, $chat_id);
                }
                
                $this->bots[$chat_id]->handleCommand($text);
        }
        
        public function run() {
                $update_id = 0;
                
                while(true) {
                        $updates = $this->telegram->getUpdates($update_id);
                        
                        if(isset($updates['ok']) && $updates['ok'] && !empty($updates['result'])) {
                                foreach($updates['result'] as $update) {
                                        $update_id = $update['update_id'] + 1;
                                        
                                        if(isset($update['message']) && isset($update['message']['text'])) {
                                                $this->handleUpdate($update);
                                        }
                                }
                        }
                        
                        sleep(1);
                }
        }
}

// Main execution
if (php_sapi_name() !== 'cli') {
    die("Bu skript faqat CLI orqali ishlaydi!\nphp bot.php");
}

echo "LITEPICK Telegram Bot ishga tushmoqda...\n";
echo "Bot token: " . BOT_TOKEN . "\n";
echo "Har bir foydalanuvchi o'z config.json fayliga ega bo'ladi.\n";
echo "Papkalar 'users_config/' ichida yaratiladi.\n\n";

$telegram = new TelegramBot(BOT_TOKEN);
$manager = new BotManager($telegram);
$manager->run();
