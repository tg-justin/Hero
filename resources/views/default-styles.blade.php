<x-app-layout>
	<x-slot name="header">
		{{ __('Title') }}
	</x-slot>
	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="dynamic">
				<h1>Heading 1 - Sample Heading Text</h1>

				<p>Here are a couple of paragraphs with no formatting so you can understand and view the line spacing.
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus convallis auctor nunc, quis
					rutrum ligula scelerisque ut. Fusce eget lacinia orci. Ut pretium orci arcu, nec condimentum nibh
					molestie ac. Donec placerat massa ultricies mauris blandit, at lobortis magna volutpat. Curabitur
					lobortis elementum quam, et aliquam lectus rhoncus quis. Ut porttitor a ligula ornare auctor.</p>

				<p>Here is the second paragraph so you can see the spacing between them. Lorem ipsum dolor sit amet,
					consectetur adipiscing elit. Phasellus convallis auctor nunc, quis rutrum ligula scelerisque ut.
					Fusce eget lacinia orci. Ut pretium orci arcu, nec condimentum nibh molestie ac.</p>

				<h2>Heading 2</h2>

				<p>This is a paragraph with an <a href="https://example.com/">Example Link</a> and a another
					<a href="https://loremflickr.com/">Sample Link</a>. We also have examples of <em>emphasis, rendered
						as italic</em>; <strong>strong as bold</strong>; <u>underline should never be used</u> and is
					the same as
					<ins>inserted text</ins>
					; <s>strikethrough serves little purpose</s> and is identical to
					<del>deleted text</del>
					;
					there is
					<mark>marked text</mark>
					; <q>quoted text</q>; <small>small text</small>
					and <code>code formatting</code>.
				</p>

				<p>The biggest problem with <sub>subscript</sub> and <sup>superscript</sup> is that they mess up the
					line spacing. For these reason alone, they suck and shouldn't be used.</p>

				<p>This is a third paragraph shown for spacing.</p>

				<h3>Heading 3</h3>

				<p>Simple paragraph for spacing before our lists.</p>

				<ul>
					<li>List Item 1</li>
					<li>List Item 2</li>
				</ul>

				<p>Between the lists.</p>

				<ol>
					<li>Ordered List Item 1</li>
					<li>Ordered List Item 2</li>
				</ol>

				<p>And after the lists.</p>

				<h4>Heading 4</h4>
				<p>Cras pharetra mollis fringilla. Ut eget neque arcu. Maecenas pretium feugiat mi, sed placerat metus elementum
					laoreet. Vivamus orci libero, hendrerit ut bibendum eget, pretium vel urna. Vestibulum id
					orci feugiat, ultrices ex et, semper neque.</p>

				<p>Cras pharetra mollis fringilla. Ut eget neque arcu. Maecenas pretium feugiat mi, sed placerat metus
					elementum laoreet. Vivamus orci libero, hendrerit ut bibendum eget, pretium vel urna. Vestibulum id
					orci feugiat, ultrices ex et, semper neque.</p>

				<blockquote>
					<p>This is a blockquote. Cras pharetra mollis fringilla. Ut eget neque arcu. Maecenas pretium
						feugiat mi, sed placerat metus elementum laoreet. Vivamus orci libero, hendrerit ut bibendum
						eget, pretium vel urna. Vestibulum id orci feugiat, ultrices ex et, semper neque.</p>
				</blockquote>


				<code>This is inline code.</code>
				<pre>This is preformatted text.</pre>
				<div class="overflow-x-auto shadow-xl rounded-lg">
					<table class="table-seance">
						<thead>
						<tr>
							<th>Table Header</th>
							<th>Table Header</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>Table Data</td>
							<td>Table Data</td>
						</tr>
						<tr>
							<td>Table Data</td>
							<td>Table Data</td>
						</tr>
						<tr>
							<td>Table Data</td>
							<td>Table Data</td>
						</tr>
						<tr>
							<td>Table Data</td>
							<td>Table Data</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>