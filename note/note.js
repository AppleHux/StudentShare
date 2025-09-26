window.addEventListener('DOMContentLoaded', fetchNotes);

async function fetchNotes() {
    try {
        const res = await fetch('/note/get_note.php');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const data = await res.json();

        if (data.error) {                // 后端主动返回错误
            alert('错误：' + data.error);
            return;
        }
        if (!data.messages || data.messages.length === 0) {
            alert('暂无留言');
            return;
        }

        /* 渲染列表 */
        const list = document.getElementById('user-list');
        list.innerHTML = '';             // 先清空旧数据
        data.messages.forEach(msg => {
            const li = document.createElement('li');
            li.textContent = `[${msg.id}] ${msg.name} · ${msg.time}: ${msg.note || '(无内容)'}`;
            list.appendChild(li);
        });

    } catch (err) {
        console.error('加载数据失败:', err);
        alert('网络或服务器异常，无法加载留言');
    }
}