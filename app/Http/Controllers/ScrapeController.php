<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class ScrapeController extends Controller
{
    /**
     * Show the form for initiating the scraping process.
     * 
     * @return \Illuminate\Contracts\View\View The view containing the scraping form.
     */

    public function showScrapeForm()
    {
        return view('scrape');
    }

    /**
     * Scrapes data from a website based on the provided name parameter.
     * 
     * @param Request $request The HTTP request object containing the input data.
     * @return \Illuminate\Contracts\View\View The view containing the scraped data or error message.
     */

    public function scrape(Request $request)
    {
        // Get the name parameter from the request
        $name = $request->input('name');

        // URL of the website to scrape
        $url = "https://www.fastpeoplesearch.com/name/$name";

        // Initialize Curl
        $curl = curl_init();

        // Set Curl options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_MAXREDIRS => 10, // Maximum number of redirects to follow
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3', // User-Agent header
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.5',
                'Connection: keep-alive',
                'Cache-Control: max-age=0',
            ],
        ]);

        try {
            // Execute Curl request
            $html = curl_exec($curl);

            // Check if the request was successful
            if ($html === false) {
                throw new \Exception('Failed to fetch data from the website');
            }

            // Parse HTML content using Simple HTML DOM Parser
            $dom = HtmlDomParser::str_get_html($html);

            // Extract data from the .people-list elements
            $results = [];
            foreach ($dom->find('.people-list') as $element) {
                $name = $element->find('.name', 0)->plaintext;
                $age = $element->find('.age', 0)->plaintext;
                $location = $element->find('.location', 0)->plaintext;

                $results[] = [
                    'name' => $name,
                    'age' => $age,
                    'location' => $location,
                ];
            }

            // Close Curl
            curl_close($curl);

            // Pass the results to the view
            return view('scrape', ['results' => $results]);
        } catch (\Exception $e) {
            // Pass the error message to the view
            return view('scrape_error', ['error' => $e->getMessage()]);
        } finally {
            // Close Curl
            curl_close($curl);
        }
    }
}
