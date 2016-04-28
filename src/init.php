<?php
/*################################################################################
//регистрируем сервис-провайдер
<<<<<<< HEAD
################################################################################*/
\Larakit\SPA::register_provider(Larakit\Page\LarakitServiceProvider::class);

/*################################################################################
  middlewares
################################################################################*/
\Larakit\SPA::register_middleware(\Larakit\Page\PageMiddlewareAfter::class);
=======
Larakit\SPA::register_provider(Larakit\Page\LarakitServiceProvider::class);
>>>>>>> 5a05a971d166dbfb14cbbe4a0290780c1ff30c3a
