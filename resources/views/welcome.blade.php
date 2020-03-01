<!DOCTYPE HTML>
<html>
    <head>
        <title>Blogv1</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="icon" href="{{ URL::asset('assets/images/Running_Man_logo_as_of_2017.png') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/placeholder-loading/dist/css/placeholder-loading.min.css">
    </head>
    <body class="is-preload">

        <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header -->
                <header id="header">
                    <h1><a href="#">Blog<small>v1</small></a></h1>
                    <nav class="links">
                        <ul>
                            <li><a href="#home">Home</a></li>
                            <li><a href="#news_blog">Forum</a></li>
                            <li><a href="#news_blog">Blog</a></li>
                            <li><a href="{{ url('/videos') }}">Videos</a></li>
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        </ul>
                    </nav>
                    <nav class="main">
                        <ul>
                            <li class="search">
                                <a class="fa-search" href="#search">Search</a>
                                <form id="search" method="get" action="#">
                                    <input type="text" name="query" placeholder="Search" />
                                </form>
                            </li>
                            <li class="menu">
                                <a class="fa-bars" href="#menu">Menu</a>
                            </li>
                        </ul>
                    </nav>
                </header>

            <!-- Menu -->
                <section id="menu">

                    <!-- Search -->
                        <section>
                            <form class="search" method="get" action="#">
                                <input type="text" name="query" placeholder="Search" />
                            </form>
                        </section>

                    <!-- Links -->
                        <section>
                            <ul class="links">
                                <li>
                                    <a href="#">
                                        <h3>Home</h3>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>Forum</h3>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/videos') }}">
                                        <h3>Videos</h3>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <h3>Blog</h3>
                                    </a>
                                </li>
                            </ul>
                        </section>

                    <!-- Actions -->
                        <section>
                            <ul class="actions stacked">
                                <li><a href="{{ url('/login') }}" class="button large fit">Log In</a></li>
                            </ul>
                        </section>

                </section>

            <!-- Main -->
                <div id="main">

                    <!-- Post -->

                    <div class="skeleton-loader">
                        @for($i = 0;$i < 2; $i++)
                            <div class="post ph-item">
                                <div>
                                    <div class="ph-row">
                                        <div class="ph-col-12 empty big"></div>
                                        <div class="ph-col-6"></div>
                                        <div class="ph-col-4 empty"></div>
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-6"></div>
                                        <div class="ph-col-4 empty"></div>
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-6"></div>
                                        <div class="ph-col-4 empty"></div>
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-12 empty big"></div>
                                    </div>
                                </div>
                                <div class="ph-col-2 small">
                                    <div class="ph-avatar"></div>
                                </div>
                                <div class="ph-col-12">
                                    <div class="ph-picture"></div>
                                    <div class="ph-row">
                                        <div class="ph-col-12"></div>
                                        <div class="ph-col-12"></div>
                                        <div class="ph-col-12"></div>
                                        <div class="ph-col-12"></div>
                                    </div>
                                    <div class="ph-row">
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-4 empty big"></div>
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-2"></div>
                                        <div class="ph-col-2"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="load-posts" style="display: none;">
                        @if(count($blogs) > 0)

                            @foreach($blogs as $key => $blog)

                                @if($key === 2)
                                    <div style="padding-bottom: 20px;background: #eee;">
                                        <center>ADVERTISEMENT</center>
                                        <center><img src="{{ URL::asset('images/slider5.jpg') }}" class="img-responsive" style="width:800px;height: 150px"></center>
                                    </div>
                                    <br>
                                @endif

                                <article class="post">
                                    <header>
                                        <div class="title">
                                            <h2><a href="{{ url('/blog/'.$blog->slug) }}">{{ $blog->title }}</a></h2>

                                            <p>{{ $blog->created_at->diffforHumans() }}</p>
                                        </div>
                                        <div class="meta">
                                            @if(empty($blog->user->avatar))
                                                  
                                                    <a href="#" class="author">
                                                        <span class="name">{{ '@'.$blog->user->username }}</span>
                                                        <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" alt="Avatar" />
                                                    </a>

                                              @else

                                                  @if(file_exists(public_path('avatar/'.$blog->user->avatar))) 

                                                    <a href="#" class="author">
                                                        <span class="name">{{ '@'.$blog->user->username }}</span>
                                                        <img src="{{ URL::asset('avatar/'.$blog->user->avatar) }}" alt="Avatar" />
                                                    </a>

                                                  @else

                                                      <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="img-circle" alt="Avatar">

                                                  @endif
                                              @endif
                                        </div>
                                    </header>
                                    <a href="#" class="image featured"><img src="{{ URL::asset('images/blog/'.$blog->image) }}" alt="{{ $blog->title }}" style="height:300px;" /></a>
                                    {!! str_limit(strip_tags($blog->content), $limit = 100, $end = '...') !!}
                                    <br>
                                    <br>
                                    <footer>
                                        <ul class="actions">
                                            <li><a href="{{ url('/blog/'.$blog->slug) }}" class="button large">Continue Reading</a></li>
                                        </ul>
                                        <ul class="stats">
                                            <li><a href="#">{{ $blog->category }}</a></li>
                                            <li><a href="#" class="icon solid fa-heart">28</a></li>
                                            <li><a href="#" class="icon solid fa-comment">128</a></li>
                                        </ul>
                                    </footer>
                                </article>

                            @endforeach

                        @else

                            No blogs posts

                        @endif
                    </div>
                    <!-- Pagination -->
                        <!-- <ul class="actions pagination">
                            <li><a href="" class="disabled button large previous">Previous Page</a></li>
                            <li><a href="#" class="button large next">Next Page</a></li>
                        </ul> -->

                </div>

            <!-- Sidebar -->
                <section id="sidebar">

                    <!-- Intro -->
                        <section id="intro">
                            <a href="#" class="logo"><img src="{{ URL::asset('assets/images/logo.jpg') }}" alt="" /></a>
                            <header>
                                <h2>Blog<small>v1</small></h2>
                            </header>
                        </section>
                        <section class="blurb">
                            <h2>About</h2>
                            <p>Content here...</p>
                            <ul class="actions">
                                <li><a href="#" class="button">Learn More</a></li>
                            </ul>
                        </section>
                    <!-- Mini Posts -->
                        <section>
                            <div class="mini-posts">
                                <!-- Mini Post -->
                                <h2>News</h2>
                                <!-- <article class="mini-post">
                                    <header>
                                        <h3><a href="#">Special Guests Who Left An Impression On “Running Man” In 2019</a></h3>
                                        <time class="published" datetime="2015-10-20">Jan 14, 2020
                                            <small style="float:right">Source: Soompi</small></time>

                                    </header>
                                    <a href="#" class="image"><img src="{{ URL::asset('assets/images/43a18663d14946a99c07277ab8781d26.webp') }}" alt="" /></a>
                                </article> -->
                            </div>
                        </section>

                    <!-- Posts List -->
                        <section>
                            <h2>Events</h2>
                            <ul class="posts">
                                <!-- <li>
                                    <article>
                                        <header>
                                            <h3><a href="#">RMU: fRactions of luck</a></h3>
                                            <time class="published" datetime="2015-10-20">June 8, 2019</time>
                                        </header>
                                        <a href="#" class="image"><img src="{{ URL::asset('assets/images/59524757_1237510726406883_2500088810755325952_o.jpg') }}" alt="" /></a>
                                    </article>
                                </li> -->
                            </ul>
                        </section>

                    <!-- Footer -->
                        <section id="footer">
                            <ul class="icons">
                                <li><a href="#" target="_blank" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                                <li><a href="#" target="_blank" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                                <li><a href="#" target="_blank" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                            </ul>
                            <p class="copyright">&copy; {{ date('Y') }}                            
                        </section>

                </section>

        </div>

        <!-- Scripts -->
        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/browser.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/breakpoints.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/util.js') }}"></script>
        <script src="{{ URL::asset('assets/js/main.js') }}"></script>

        <script type="text/javascript">
            
            loadPosts();

            function loadPosts() {

                setTimeout(function(){ 

                    $('.skeleton-loader').hide();

                    $('.load-posts').show();

                }, 5000);
            }

        </script>
    </body>
</html>