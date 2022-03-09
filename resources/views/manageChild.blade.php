<ul>
@foreach($childs as $child)
	<li>
	    {{ $child->name }}
		@if($child->children)
			<?php
				$files = $child->files;
				$childrenData = $child->children;
				$merged = $childrenData;
				if ($files) {
					$merged = $childrenData->merge($files);
				}
			?>
            @include('manageChild',['childs' => $merged])
        @endif
	</li>
@endforeach
</ul>