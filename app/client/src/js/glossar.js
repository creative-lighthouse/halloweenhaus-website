// Automatic glossary for wiki pages
(async function() {
    try {
        // Fetch the wiki index
        const response = await fetch('https://halloweenhaus-website.ddev.site/api/wikiindex');
        const wikiIndex = await response.json();

        if (!wikiIndex || !Array.isArray(wikiIndex)) {
            console.error('Invalid wiki index format');
            return;
        }

        // Get all elements with the glossarizable class
        const glossarizableElements = document.querySelectorAll('.glossarizable');

        if (glossarizableElements.length === 0) {
            console.log('No elements with class "glossarizable" found');
            return;
        }

        // Create a map of terms to links
        const glossaryMap = new Map();
        wikiIndex.forEach(item => {
            if (item.title && item.link) {
                glossaryMap.set(item.title.toLowerCase(), item.link);
            }
        });

        // Sort terms by length (longest first) to avoid partial replacements
        const sortedTerms = Array.from(glossaryMap.keys()).sort((a, b) => b.length - a.length);

        // Process each glossarizable element
        glossarizableElements.forEach(contentElement => {
            // Walk through text nodes and replace terms
            const walker = document.createTreeWalker(
                contentElement,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function(node) {
                        // Skip if parent is already a link, script/style tag, or heading
                        if (node.parentElement.tagName === 'A' ||
                                node.parentElement.tagName === 'SCRIPT' ||
                                node.parentElement.tagName === 'STYLE' ||
                                node.parentElement.tagName === 'H1' ||
                                node.parentElement.tagName === 'H2' ||
                                node.parentElement.tagName === 'H3' ||
                                node.parentElement.tagName === 'H4' ||
                                node.parentElement.tagName === 'H5' ||
                                node.parentElement.tagName === 'H6') {
                            return NodeFilter.FILTER_REJECT;
                        }
                        return NodeFilter.FILTER_ACCEPT;
                    }
                }
            );

            const textNodes = [];
            let currentNode;
            while (currentNode = walker.nextNode()) {
                textNodes.push(currentNode);
            }

            // Process each text node
            textNodes.forEach(node => {
            let text = node.textContent;
            let hasMatch = false;

            sortedTerms.forEach(term => {
                const regex = new RegExp(`\\b${term}\\b`, 'gi');
                if (regex.test(text)) {
                    hasMatch = true;
                }
            });

            if (hasMatch) {
                const fragment = document.createDocumentFragment();
                let lastIndex = 0;
                const matches = [];

                // Find all matches
                sortedTerms.forEach(term => {
                    const regex = new RegExp(`\\b${term}\\b`, 'gi');
                    let match;
                    while ((match = regex.exec(text)) !== null) {
                        matches.push({
                            index: match.index,
                            length: match[0].length,
                            term: term,
                            matched: match[0]
                        });
                    }
                });

                // Sort matches by position and remove overlaps
                matches.sort((a, b) => a.index - b.index);
                const filteredMatches = [];
                matches.forEach(match => {
                    const overlaps = filteredMatches.some(existing =>
                        match.index < existing.index + existing.length
                    );
                    if (!overlaps) {
                        filteredMatches.push(match);
                    }
                });

                // Build the new content
                filteredMatches.forEach(match => {
                    // Add text before match
                    if (match.index > lastIndex) {
                        fragment.appendChild(document.createTextNode(text.substring(lastIndex, match.index)));
                    }

                    // Add link
                    const link = document.createElement('a');
                    link.href = glossaryMap.get(match.term);
                    link.textContent = match.matched;
                    link.className = 'glossary-link';
                    fragment.appendChild(link);

                    lastIndex = match.index + match.length;
                });

                // Add remaining text
                if (lastIndex < text.length) {
                    fragment.appendChild(document.createTextNode(text.substring(lastIndex)));
                }

                // Replace the text node with the fragment
                node.parentNode.replaceChild(fragment, node);
            }
            });
        });

    } catch (error) {
        console.error('Error loading glossary:', error);
    }
})();
