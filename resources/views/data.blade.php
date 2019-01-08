@if ($results)
		@foreach ($results as $element)
			<table>
				<tr>
					<td>{{ $element->merit }}</td>
					<td>{{ $element->student_no }}</td>
					<td>{{ $element->student_name }}</td>
					<td>{{ $element->hall_name }}</td>
				</tr>
			</table>
		@endforeach
	@endif

	