<div>
    <input type="file" wire:model="pdf">
    {{-- @error('pdf')
        <span>{{ $message }}</span>
    @enderror --}}

    <button type="submit">Upload PDF</button>
</div>
<script>
    // Save the original fetch function
    const originalFetch = window.fetch;
    window.fetch = function(url, options) {
        // if (options.method && options.method.toUpperCase() === 'POST') {
        try {
            console.log(options.body);
            const temp = JSON.parse(options.body);

            if (typeof temp.serverMemo === 'string') {
                return originalFetch(url, options); // Return the original fetch for this case
            } else {
                temp.serverMemo = btoa(unescape(encodeURIComponent(JSON.stringify(temp.serverMemo))));
            }

            if (typeof temp.updates === 'string') {
                return originalFetch(url, options); // Return the original fetch for this case
            } else {
                temp.updates = btoa(unescape(encodeURIComponent(JSON.stringify(temp.updates))));
            }
            options.body = JSON.stringify(temp);
            console.log(options.body);
        } catch (error) {
            // console.error('Error parsing JSON:', error);
            return originalFetch(url, options); // Return the original fetch if there's an error parsing JSON
        }
        // }

        // Call the original fetch function
        return originalFetch(url, options)
            .then(response => {
                return response;
            })
            .catch(error => {
                // Handle errors
                console.error('Error:', error);
            });
    };
</script>

