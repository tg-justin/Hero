<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200">
            {{ __('Title') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-cover bg-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <p>This is a paragraph of text.</p>
        <ul>
            <li>List Item 1</li>
            <li>List Item 2</li>
        </ul>
        <ol>
            <li>Ordered List Item 1</li>
            <li>Ordered List Item 2</li>
        </ol>
        <a href="#">This is a link</a>
        <blockquote>This is a blockquote.</blockquote>
        <code>This is inline code.</code>
        <pre>This is preformatted text.</pre>
        <table>
            <tr><th>Table Header</th><th>Table Header</th></tr>
            <tr><td>Table Data</td><td>Table Data</td></tr>
        </table>
        </div>
    </div>
</x-app-layout>
