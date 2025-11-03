<?php

use App\Models\School;
use Filament\Facades\Filament;

if (!function_exists('tenant')) {
    function tenant()
    {
        return Filament::getTenant();
    }
}
// Note: activity() helper is provided by Spatie\Laravel-Activitylog
// Our custom MyActivityLogger and MyPendingActivityLog are bound in ActivityLogServiceProvider

if (!function_exists('aLog')) {
    function aLog($school_id, $message,$causer = null,$model = null,$event = null,$properties=[])
    {
        $log = activity()
            ->school_id($school_id)
            ->level('system')
            ->causedBy($causer);                     // who

        if ($model) {
            $log->performedOn($model);              // on what model
        }

        $log->event($event)                          // optional custom event name
            ->withProperties($properties)
            ->log($message);
    }
}

if (!function_exists('subdomain')) {
    function subdomain()
    {
        $path = request()->path();
        // segment is of the form /admin/CCJP
        $segments = explode('/', $path);

        //dd($segments);
        if (count(request()->segments()) <= 2 && count($segments) >1){
            return $segments[1];
        }
        else{
            return '';
        }
        // First try to get from URL path (for tenant-based URLs like /admin/perla/account)

        // dd(count($segments));

        // If URL is like admin/perla/something, return 'perla'
        if (count($segments) >= 2 && $segments[0] === 'admin' && $segments[1] !== '') {
            return $segments[1];
        }

        // Fallback to host-based subdomain
        $host = request()->getHost(); // Returns full domain e.g. "subdomain.example.com"
        $subdomain = explode('.', $host)[0];
        return $subdomain;
    }
}

if (!function_exists('local')) {
    function local(){
        if (env('APP_ENV')=='local'){
            return true;
        }
        return false;
    }
}

if (!function_exists('school_id')) {
    function school_id($default = 1):int{ // default should work only for dev
//        return 1;
        $tenant = null;

        $tenant = Filament::getTenant();
        //dd($tenant);
        if ($tenant!=null){

            return $tenant->id;
        }

        // we dont have direct tenant, lets find it by subdomain
        $subdomain = subdomain();
        //dd($subdomain);;

        try {
            if (in_array($subdomain, ['admin', 'api'])){
                return $default;
            }
            $school = School::where('name', $subdomain)->first();
            if ($school == null) {
                //dump('school not found');
                return $default;
            }
            return $school->id;
        }
        catch (Exception $exception){
            echo 'dddb may not be initialized';
        }

        return $default;
    }
}

if (!function_exists('protocol')) {
    function protocol():string{
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
        return $protocol;
    }
}

if (!function_exists('contains_profanity')) {
    function contains_profanity(string $text): bool
    {
        $profanityWords = [
            // Mexican/Spanish curse words
            'pendejo', 'cabrón', 'cabron', 'puto', 'puta', 'mierda', 'joder',
            'coño', 'cono', 'chingada', 'chingar', 'pinche', 'verga', 'mamada',
            'culero', 'ojete', 'huevón', 'huevon', 'huevos', 'huevo', 'ahuevo', 'a huevo', 'webos', 'webo', 'marica', 'maricon', 'maricón',
            'pendejada', 'putada', 'chingadazo', 'chingadera', 'chingaderas',
            'nalgas', 'culo', 'pedo', 'cagar', 'caga', 'me cago', 'chichis', 'tetas', 'mierdero', 'jodido',
            'jodida', 'putear', 'putero', 'putita', 'zorra', 'zorrita',
            'baboso', 'babosa', 'estúpido', 'estupido', 'imbécil', 'imbecil',
            'idiota', 'tarado', 'tarada', 'mamón', 'mamon', 'mamona',
            'chingón', 'chingon', 'chingona', 'pinches', 'pinchis',
            'güey', 'guey', 'wey', 'buey', 'culei', 'culiao', 'malparido',
            'hijueputa', 'hijo de puta', 'hdp', 'gonorrea', 'chimba',
            // English curse words
            'fuck', 'shit', 'bitch', 'damn', 'ass', 'bastard', 'crap',
            'asshole', 'dickhead', 'motherfucker', 'whore', 'slut',
        ];

        $text = strtolower($text);

        // Remove spaces, dots, dashes, underscores to catch variations like "p u t o", "p.u.t.o", "p-u-t-o"
        $cleanText = preg_replace('/[\s\.\-_]+/', '', $text);

        foreach ($profanityWords as $word) {
            $cleanWord = strtolower($word);

            // Use word boundaries to avoid false positives like "cap" in "academic-cap"
            // Check original text with word boundaries
            if (preg_match('/\b' . preg_quote($cleanWord, '/') . '\b/', $text)) {
                return true;
            }

            // For cleaned text, check if the word appears as a complete segment
            // separated by common separators
            if (preg_match('/(^|[\s\.\-_])' . preg_quote($cleanWord, '/') . '([\s\.\-_]|$)/', $cleanText)) {
                return true;
            }
        }

        return false;
    }
}

