<?php

namespace Helpers;

use CStr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JSON
{
    /**
     * Loads the JSON file from provided path and returns it's parsed contents
     *
     * @param string $filename    Name of the JSON file to load
     * @param string $directory   The directory to look the JSON file in,
     *                            defaults to `resources/data`
     * @param bool   $assoc       Whether to convert the JSON into an
     *                            associative array or not (if is valid JSON).
     *                            Default is `true`
     *
     * @return mixed              Returns the parsed JSON content or a `null`
     *                            either if the file has invalid content or is
     *                            empty
     */
    public static function parseFile(string $filename, string $directory = null, $assoc = true)
    {
        // Validate the passed directory, else default to `resources/data`
        $directory = CStr::isValidString($directory) ? $directory : resource_path('data');

        // Merge the directory name and provided filename to make a complete
        // file path
        $path = sprintf('%s/%s', $directory, $filename);

        // The file does not exists!
        if (!file_exists($path)) return null;

        return @json_decode(file_get_contents($path), $assoc) ?? null;
    }

    public static function success(
        mixed $data = null,
        int $status = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'status' => $status,
            'data' => $data,
        ], $status, $headers);
    }

    public static function error(
        mixed $message = null,
        int $status = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
        ], $status, $headers);
    }
}
