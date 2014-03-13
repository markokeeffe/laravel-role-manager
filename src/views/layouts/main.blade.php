<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">-->
		<link href="{{ URL::asset('packages/markokeeffe/role-manager/assets/css/bootstrap.css') }}" rel="stylesheet">

		<style>
			table form { margin-bottom: 0; }
			form ul { margin-left: 0; list-style: none; }
			.error { color: red; font-style: italic; }
			body { padding-top: 60px; }
			table .controls .btn {
			  margin-left: 5px;
			}
		</style>
	</head>

	<body>

		<div class="container">

					<!-- Navbar -->
    			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::action('MOK\RoleManager\UserController@index') }}">Role Manager</a>
              </div>



              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    @include('RoleManager::menus.mainMenu')
                </ul>
              </div>
            </div><!-- ./ container -->
    			</nav>
    			<!-- ./ navbar -->

      <h1>@yield('title')</h1>

			@if (Session::has('message'))
				<div class="alert alert-warning">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

			@yield('main')
		</div>

    @include('RoleManager::layouts.modal')

    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/jquery-2.0.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/bootstrap.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/application.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/behaviors/modal.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/behaviors/ajaxLink.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/behaviors/ajaxForm.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('packages/markokeeffe/role-manager/assets/js/behaviors/toggleHidden.js') }}"></script>

	</body>

</html>
