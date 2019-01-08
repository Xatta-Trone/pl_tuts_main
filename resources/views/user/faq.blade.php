@extends('user.app')

@section('page_title','FAQ')


@section('main_content')

	<div class="section_padding hero_title_section">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<h3>FAQ</h3>
					<span></span>
					<p>Because you may have some questions</p>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding faq_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div id="accordion">

					@foreach ($faqs as $faq)
					  <div class="card">
					    <div class="card-header" id="faq_{{$faq->id}}">
					      <h5 class="mb-0">
					        <a class="card-link" data-toggle="collapse" data-target="#collapse_{{$faq->id}}" aria-expanded="false" aria-controls="collapse_{{$faq->id}}">
					          {{$faq->title}}
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					      </h5>
					    </div>

					    <div id="collapse_{{$faq->id}}" class="collapse" aria-labelledby="faq_{{$faq->id}}" data-parent="#accordion">
					      <div class="card-body">
					        {!! $faq->body !!}
					      </div>
					    </div>
					  </div>
					@endforeach



					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

