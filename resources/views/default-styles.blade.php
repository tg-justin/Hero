<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200">
            {{ __('Title') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-cover bg-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="quest_body">
                <h1>Heading 1</h1>
                <p>Sample paragraph text with <a href="https://example.com/">Example - Link 1</a> and <a
                        href="https://example.com/">Example - Link 1</a>. We also have an example of different
                    formattings including <em>Emphasis, which is typically displayed as italic</em>; <strong>Strong or
                        bold</strong>; <u>Underline</u>; and <s>Strikethrough</s>.
                <p>
                <p>Though they are not used as often, we also have <sub>Subscript</sub> and <sup>Superscript</sup> text.
                    Not to mention
                    <mark>Marked, or highlighted text</mark>
                    and
                    <del>Deleted text</del>
                    . There is also <code>code formatting</code> formatting, but do we plan to actually use this for
                    anything?
                </p>
                <p>Cras pharetra mollis fringilla. Ut eget neque arcu. Maecenas pretium feugiat mi, sed placerat metus
                    elementum laoreet. Vivamus orci libero, hendrerit ut bibendum eget, pretium vel urna. Vestibulum id
                    orci feugiat, ultrices ex et, semper neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Duis hendrerit, diam vitae consectetur malesuada, nibh erat consectetur nisl, sit amet commodo sem
                    est eget lectus. Phasellus pellentesque dui libero, ac sollicitudin nibh ultricies nec. Aliquam erat
                    volutpat.
                </p>
                <h2>Heading 2</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pharetra mollis fringilla. Ut eget
                    neque arcu. Maecenas pretium feugiat mi, sed placerat metus elementum laoreet. Vivamus orci libero,
                    hendrerit ut bibendum eget, pretium vel urna. </p>
                <p>Vestibulum id orci feugiat, ultrices ex et, semper neque. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Duis hendrerit, diam vitae consectetur malesuada, nibh erat consectetur nisl, sit
                    amet commodo sem est eget lectus. Phasellus pellentesque dui libero, ac sollicitudin nibh ultricies
                    nec. Aliquam erat volutpat.</p>
                <h3>Heading 3</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pharetra mollis fringilla. Ut eget
                    neque arcu. Maecenas pretium feugiat mi, sed placerat metus elementum laoreet. Vivamus orci libero,
                    hendrerit ut bibendum eget, pretium vel urna. </p>
                <p>Vestibulum id orci feugiat, ultrices ex et, semper neque. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Duis hendrerit, diam vitae consectetur malesuada, nibh erat consectetur nisl, sit
                    amet commodo sem est eget lectus. Phasellus pellentesque dui libero, ac sollicitudin nibh ultricies
                    nec. Aliquam erat volutpat.</p>
                <ul>
                    <li>List Item 1</li>
                    <li>List Item 2</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pharetra mollis fringilla. Ut eget
                    neque arcu. Maecenas pretium feugiat mi, sed placerat metus elementum laoreet. Vivamus orci libero,
                    hendrerit ut bibendum eget, pretium vel urna. </p>
                <p>Vestibulum id orci feugiat, ultrices ex et, semper neque. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Duis hendrerit, diam vitae consectetur malesuada, nibh erat consectetur nisl, sit
                    amet commodo sem est eget lectus. Phasellus pellentesque dui libero, ac sollicitudin nibh ultricies
                    nec. Aliquam erat volutpat.</p>
                <ol>
                    <li>Ordered List Item 1</li>
                    <li>Ordered List Item 2</li>
                </ol>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pharetra mollis fringilla. Ut eget
                    neque arcu. Maecenas pretium feugiat mi, sed placerat metus elementum laoreet. Vivamus orci libero,
                    hendrerit ut bibendum eget, pretium vel urna. </p>
                <p>Vestibulum id orci feugiat, ultrices ex et, semper neque. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Duis hendrerit, diam vitae consectetur malesuada, nibh erat consectetur nisl, sit
                    amet commodo sem est eget lectus. Phasellus pellentesque dui libero, ac sollicitudin nibh ultricies
                    nec. Aliquam erat volutpat.</p>
                <blockquote>This is a blockquote.</blockquote>
                <code>This is inline code.</code>
                <pre>This is preformatted text.</pre>
                <table>
                    <tr>
                        <th>Table Header</th>
                        <th>Table Header</th>
                    </tr>
                    <tr>
                        <td>Table Data</td>
                        <td>Table Data</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
