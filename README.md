# Twitter Clone 

## Laravel Lumen 

## Entry Point  [ How to Run or Test ]

### Unit Testing 

### 

## Twitter Standard Json Response 

`{
  "created_at": "Thu Apr 06 15:24:15 +0000 2017",
  "id_str": "850006245121695744",
  "text": "1\/ Today we\u2019re sharing our vision for the future of the Twitter API platform!\nhttps:\/\/t.co\/XweGngmxlP",
  "user": {
    "id": 2244994945,
    "name": "Twitter Dev",
    "screen_name": "TwitterDev",
    "location": "Internet",
    "url": "https:\/\/dev.twitter.com\/",
    "description": "Your official source for Twitter Platform news, updates & events. Need technical help? Visit https:\/\/twittercommunity.com\/ \u2328\ufe0f #TapIntoTwitter"
  },
  "place": {   
  },
  "entities": {
    "hashtags": [      
    ],
    "urls": [
      {
        "url": "https:\/\/t.co\/XweGngmxlP",
        "unwound": {
          "url": "https:\/\/cards.twitter.com\/cards\/18ce53wgo4h\/3xo1c",
          "title": "Building the Future of the Twitter API Platform"
        }
      }
    ],
    "user_mentions": [     
    ]
  }
}
`

Test
./vendor/bin/phpunit tests/Integration/Controllers/UserControllerTest.php

./vendor/bin/phpunit tests/Integration/Controllers/PostCommentControllerTest.php

http://localhost:8000

php -S localhost:8000 -t public

Entity
"entities": {
    "hashtags": [
    ],
    "urls": [
    ],
    "user_mentions": [
    ],
    "symbols": [
    ]
  }

   - Hashtag object

  - Media object
  - Media size object
  - URL object

  - User mention object

  - Symbol object

  - Poll object