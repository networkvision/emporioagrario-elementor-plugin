<?php 

// Magento Integration

// Consumer key: 08460o6ktmivegmfwomupu154j2dres9
// Consumer secret: 8jmvbur6m6nqpabubdne79kqs51dolqb
// Token di accesso: qvth9pxg9l2775xmo0z57yh4kn0qcxi6
// Segreto del Token di accesso: pc3oz9xzuegw0gffeopealw0f0dewsf0

function ea_shortcodes_shop_products_slider() {
    
$apiUrl = EMPORIO_AGRARIO_MAGENTO2_API_URL . "products";
$accessToken = EMPORIO_AGRARIO_MAGENTO2_API_TOKEN;
$html = '';
//$jsonData = json_encode(["id" => {}]); // Replace with your actual data

// Set up search criteria
$searchCriteria = [
    'searchCriteria[filter_groups][0][filters][0][field]' => 'name',
    'searchCriteria[filter_groups][0][filters][0][value]' => '%25', // Wildcard for any name
    'searchCriteria[filter_groups][0][filters][0][condition_type]' => 'like'
];

// Build query string from the search criteria array
$queryString = http_build_query($searchCriteria);

// Append query string to the API URL
$fullApiUrl = $apiUrl . "?" . $queryString;

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fullApiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $accessToken
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and close it
$response = curl_exec($ch);
curl_close($ch);

// Check for cURL errors
if ($response === false) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// Decode JSON response
$responseData = json_decode($response, true);


//var_dump($responseData);

$html = '<div class="swiper-container">
    <div class="swiper-wrapper">';
        foreach ($responseData['items'] as $item): 
            // Construct the URL to the product page
            $productUrl = "https://shop.emporioagrario.it/" . $item['custom_attributes'][4]['value'] . ".html";
            $shortDescription = $item['custom_attributes'][2]['value']; // Assuming this is the short description
            
            $html .= '<div class="swiper-slide"><a href="' . $productUrl . '" target="_blank" title="' . $item['name'] . '"><img src="https://shop.emporioagrario.it/pub/media/catalog/product' . $item['custom_attributes'][3]['value'] . '" alt="' .  $item['name'] . '"><h3>'. $item['name'] . '</h3><p>' . $shortDescription . '</p><div class="price">€' . $item['price'] . '</div></a></div>';
        endforeach;
    $html .= '</div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Navigation -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>';

return $html;


}

add_shortcode( 'ea_shop_products_slider', 'ea_shortcodes_shop_products_slider' );