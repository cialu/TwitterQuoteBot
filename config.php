<?php
require_once('twitteroauth.php');

define('CONSUMER_KEY', 'your_consumer_key_here');
define('CONSUMER_SECRET', 'your_consumer_secret_here');
define('ACCESS_TOKEN', 'your_access_token_here');
define('ACCESS_TOKEN_SECRET', 'your_access_token_secret_here');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$quoteToTweet = "A noi giovani costa doppia fatica mantenere le nostre opinioni in un tempo in cui ogni idealismo è annientato e distrutto, in cui gli uomini si mostrano dal loro lato peggiore.
Anna Frank"; // put here just a base text of over 140 characters

/**
 * Check if the tweet text is of right lenght.
 */

for ($i = 1; ; $i++) {
    if (strlen($quoteToTweet) <= 140) {
        break;
    } else {
      $quoteToTweet = ""; $quoteToTweet = getTweet();
    }
}

/**
 * If lenght is correct, post the tweet.
 */

$twitter->post('statuses/update', array('status' => $quoteToTweet));

echo "Success! Check your twitter!";

/**
 * Get tweet content and strip HTML tags.
 */

function getTweet() {
  $quote = "put_here_your_text_source";
  $quote = str_ireplace("<BR>", "AAA", $quote);
  $quote = preg_replace('/<[^>]*>/', ' ',getHtml($quote));
  $quote = str_ireplace("AAA", " ", $quote);
  return $quote;
}


/**
 * Get url content.
 */

function getHtml($url, $post = null) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  if(!empty($post)) {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}
?>
