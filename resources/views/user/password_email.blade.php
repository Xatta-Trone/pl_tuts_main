@extends('user.app')

@section('page_title','Reset Password')
@section('main_content')
	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>Change Password</h3>
						<span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding grey_bg register_page">
			<div class="container">
				<div class="row">
					<div class="col-lg-7 col-xl-6 mx-auto col-md-10">
						* Password must be at least 6 characters.
						<form method="POST" action="{{ route('password.request') }}">
							{{ csrf_field() }}

                        	<input type="hidden" name="token" value="{{ $token }}">
							
							<div class="field">
								<label for="email">Email</label>
								 <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                 @if ($errors->has('email'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('email') }}</strong>
                                     </span>
                                 @endif
							</div>

							<div class="field">
								<label for="password">New Password</label>
								<input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
							</div>


							<div class="field">
								<label for="password-confirm">Confirm Password</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
							</div>

							<hr>
							<input type="submit" name="submit" value="Reset Password">
						</form>


					</div>
				</div>
			</div>
		</div>
@endsection

