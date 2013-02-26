Recombu Cars Experience Advisor
===============================

This was created for the hackathon at PHPUK2013.
For more information, see: https://www.hackerleague.org/hackathons/php-uk-conference-hackathon/hacks/recombu-cars-experience-advisor

1) Installation
---------------

    git clone https://github.com/hackzilla/hackathon2013.git
    cp app/config/parameters.yml.defaults app/config/parameters.yml
    add database, twilio and pusher details to parameters.yml
    set permission for app/cache and app/logs directories
    composer install
    app/console cache:clear --env=prod --no-debug


2) Running
----------

    There are 3 parts to the site:

    1) Website [http://domain.com]
    2) Admin [http://domain.com/admin]
    3) Pusher event listener [http://domain.com/pusher/listen]


Note:
-----

This is a hack and is not ideally how we'd code given sufficient time.
