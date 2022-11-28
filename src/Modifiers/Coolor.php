<?php

namespace Michaelmannucci\Coolor\Modifiers;

use Statamic\Modifiers\Modifier;
use Mexitek\PHPColors\Color;

class Coolor extends Modifier
{
    public function index($value, $params)
    {
        // Convert HEX to HSL
        $color = Color::hexToHsl($value);
        
        // Add Hue
        if (in_array("addhue", $params)) {
            $index = array_search("addhue", $params);
            $hue = $color["H"] + $params[$index + 1];

            if ($hue > 360) {
                $hue = $hue - 360;
            }

            $color["H"] = $hue;
        }

        // Subtract Hue
        if (in_array("subhue", $params)) {
            $index = array_search("subhue", $params);
            $hue = $color["H"] - $params[$index + 1];

            if ($hue < 0) {
                $hue = $hue + 360;
            }

            $color["H"] = $hue;
        }
           
        // Set Saturation
        if (in_array("sat", $params)) {
            $index = array_search("sat", $params);
            $color["S"] = ($params[$index + 1] / 100);
        }

        // Set Luminance
        if (in_array("lum", $params)) {
            $index = array_search("lum", $params);
            $color["L"] = ($params[$index + 1] / 100);
        }

        // Add Saturation
        if (in_array("addsat", $params)) {
            $index = array_search("addsat", $params);
            $color["S"] = $color["S"] + ($color["S"] * ($params[$index + 1] / 100));

            if ($color["S"] > 100) {
                $color["S"] == 100;
            }
        }

        // Subtract Saturation
        if (in_array("subsat", $params)) {
            $index = array_search("subsat", $params);
            $color["S"] = $color["S"] - ($color["S"] * ($params[$index + 1] / 100));

            if ($color["S"] < 0) {
                $color["S"] == 0;
            }
        }

        // Shade
        if (in_array("shade", $params)) {
            $index = array_search("shade", $params);

            $color = "#".Color::hslToHex($color);
            $rgb = Color::hextoRgb($color);

            $rgb["R"] = round($rgb["R"] * (((100 - $params[$index + 1]) / 100)));
            $rgb["G"] = round($rgb["G"] * (((100 - $params[$index + 1]) / 100)));
            $rgb["B"] = round($rgb["B"] * (((100 - $params[$index + 1]) / 100)));

            $color = Color::rgbtoHex($rgb);
            $color = Color::hextoHsl($color);
        }

        // Tint
        if (in_array("tint", $params)) {
            $index = array_search("tint", $params);

            $color = "#".Color::hslToHex($color);
            $rgb = Color::hextoRgb($color);

            $rgb["R"] = round($rgb["R"] + (($params[$index + 1] / 100) * (255 - $rgb["R"])));
            $rgb["G"] = round($rgb["G"] + (($params[$index + 1] / 100) * (255 - $rgb["G"])));
            $rgb["B"] = round($rgb["B"] + (($params[$index + 1] / 100) * (255 - $rgb["B"])));

            $color = Color::rgbtoHex($rgb);
            $color = Color::hextoHsl($color);
        }

        // Convert HSL to HEX
        return "#".Color::hslToHex($color);

    }
}
