<?php

use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
    private $accessToken = null;
    
    private $guzzleClient;
    
    private $refreshToken = "a0Q43GhECOVryJPwBzeylcosieDjWZKFzu6JCPCWAeVhjmHIc5lFK7CnPtcMnqIe";
    
    private $artists = [];
    
    private $artistOffset = 372736;
    
    private $apiRateLimit = 0;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingArtists = \App\Models\Artist::select('chartmetric_artist_id')
            ->get()->pluck('chartmetric_artist_id')->toArray();

        // Set guzzle client
        $this->guzzleClient = new \GuzzleHttp\Client();
        
        // Fetch access token
        $this->cmAccessToken();
        
        do {
            // Fetch list of artists
            $this->artists();
            foreach ($this->artists as $artist) {
           //    if ($artist->chartmetric_artist_id === 341383) {
             //       echo '<pre>'; print_r($this->artistOffset);
               //     die('end');
               // }
            if (!in_array($artist->chartmetric_artist_id, $existingArtists)) {
                    $this->artistMetadata((array)$artist);
                }
                $this->artistOffset++;
            }
        } while (!empty($this->artists));
    }
    
    /**
     * @return void
     */
    private function cmAccessToken(): void
    {
        try {
            $this->incrementApiRateLimit();
            $response = $this->guzzleClient->post(
                'https://api.chartmetric.com/api/token',
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode(
                        [
                            "refreshtoken" => $this->refreshToken
                        ]
                    )
                ]
            );
            $authResponse = json_decode($response->getBody()->getContents());
            $this->accessToken = $authResponse->token;
            echo '<pre>'; print_r("token response\n");
        } catch (Exception $exception) {
            echo '<Pre>'; print_r($exception);
        }
    }
    
    private function artists(): void
    {
        try {
            $this->incrementApiRateLimit();
            $artists = $this->guzzleClient->get(
                "https://api.chartmetric.com/api/artist/cm_artist_rank/list?min=0&max=500000000&offset={$this->artistOffset}",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$this->accessToken}"
                    ]
                ]
            );
            $artists = json_decode($artists->getBody()->getContents());
            $this->artists = $artists->obj->data;
            echo '<pre>'; print_r("artists response => {$artists->obj->length}, offset => {$this->artistOffset} \n");
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            if (in_array($response->error, ['jwt expired', 'invalid token'])) {
                $this->incrementApiRateLimit();
                $oldAccessToken = $this->accessToken;
                $this->cmAccessToken();
                if ($this->accessToken && ($this->accessToken !== $oldAccessToken)) {
                    $this->artists();
                } else {
                    $this->artists = [];
                }
            } else {
                $this->artists = [];
                echo '<pre>'; print_r($exception->getMessage());
                echo '<pre>'; print_r("artistOffset => {$this->artistOffset}\n");
            }
        }
    }
    
    private function incrementApiRateLimit(): void
    {
        if ($this->apiRateLimit === 98) {
            $this->apiRateLimit = 0;
            sleep(300);
        }
        $this->apiRateLimit++;
    }
    
    private function artistMetadata(array $artist): void
    {
        try {
            $this->incrementApiRateLimit();
            $artistMetadata = $this->guzzleClient->get(
                "https://api.chartmetric.com/api/artist/{$artist['chartmetric_artist_id']}",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$this->accessToken}"
                    ]
                ]
            );
            $metaData = json_decode($artistMetadata->getBody()->getContents(), true);
            \App\Models\Artist::create(
                array_merge(
                    \Illuminate\Support\Arr::only(
                        array_merge($artist, $metaData['obj']),
                        (new \App\Models\Artist())->getFillable()
                    )
                )
            );
            echo '<pre>'; print_r("artist metadata => {$artist['chartmetric_artist_id']} \n");
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            if (in_array($response->error, ['jwt expired', 'invalid token'])) {
                $this->incrementApiRateLimit();
                $oldAccessToken = $this->accessToken;
                $this->cmAccessToken();
                if ($this->accessToken && ($this->accessToken !== $oldAccessToken)) {
                    $this->artistMetadata($artist);
                } else {
                    echo '<pre>'; print_r($exception->getMessage());
                    echo '<pre>'; print_r("artistOffset => {$this->artistOffset}\n");
                }
            } else {
                sleep(60);
                echo '<pre>'; print_r($exception->getMessage());
                echo '<pre>'; print_r("artistOffset => {$this->artistOffset}\n");
            }
        } catch (Exception $exception) {
            echo '<pre>'; print_r('second catch');
            echo '<pre>'; print_r($exception->getMessage());
            echo '<pre>'; print_r($exception->getCode());
            echo '<pre>'; print_r("artistOffset => {$this->artistOffset}\n");
            echo '<pre>'; print_r('second catch');
            sleep(60);
        }
    }
}
