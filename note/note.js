async function fetchNotes() {
    // 1. 请求数据
    const res = await fetch('/note/pull_note.php');
    const data = await res.json();

    // 2. 找到列表容器
    const list = document.getElementById('note');
    list.innerHTML = '';  // 清空

    // 3. 循环添加留言
    data.messages.forEach(msg => {
        const li = document.createElement('li');
        li.textContent = `[${msg.id}] ${msg.username} · ${msg.time}: ${msg.content}`;
        list.appendChild(li);
    });
}

// 页面加载完成后执行
document.addEventListener('DOMContentLoaded', fetchNotes);