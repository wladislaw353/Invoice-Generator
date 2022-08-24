function setResponse(boxSelector, data) {
    const responseBox = document.querySelector(boxSelector)
    if (responseBox) {
        responseBox.innerHTML = data
    }
}

async function ajax(url, data) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: data
        })
        if (response.status != 200) {
            return 'Error! Bad Server Response'
        }
        const result = await response.text()
        try {
            const json = JSON.parse(result)
            return {
                isError: json.isError ?? true,
                data: json.data || json
            }
        } catch {
            console.error('Non-JSON response received')
            return {
                isError: true,
                data: result
            }
        }
    } catch (error) {
        alert(`Unknown error ocurred`)
        console.trace(`${error}`)
    }
}

function processForm(selector, apiEndpoint) {
    const form = document.querySelector(selector)
    form.addEventListener('submit', async event => {
        event.preventDefault()
        const formData = new FormData(form)
        const responseBox = `${selector} + span`
        setResponse(responseBox, 'Loading…')
        const { isError, data } = await ajax(apiEndpoint, formData)
        let visualData = `${data}` || 'None'
        if (!isError) {
            if (Array.isArray(data)) {
                const invoiceLink = file => `<div class="item">
                    <span>${file.name}</span>
                    <a href="${file.link}" target="_blank">View PDF</a>
                    <a href="${file.link}" download>Download PDF</a>
                </div>`
                visualData = ''
                const invoicesBox = document.querySelector('#invoices')
                const invoicesList = data.map(invoiceLink).join('')
                invoicesBox.innerHTML = invoicesList
            }
        }
        setResponse(responseBox, visualData)
    })
}

processForm('#create', '/app/generate_users.php')
processForm('#generate', '/app/generate_invoice.php')