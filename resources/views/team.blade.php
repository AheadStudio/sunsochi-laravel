@extends("layouts.app")

@section("content")
	<h1>Сотрудники</h1>
	<?php foreach ($blogsInfo as $blog): ?>
		<p style="font-size:16px;display: block; border-bottom: 1px solid #000;"><? echo $blog->name; ?></p>
	<?php endforeach; ?>
@endsection
