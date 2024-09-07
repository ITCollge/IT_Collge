document.addEventListener('DOMContentLoaded', function() {
    // إضافة حدث عند تغيير الصفحة في نموذج إضافة خبر
    document.getElementById('page').addEventListener('change', function() {
        const pageValue = this.value;
        if (pageValue === 'departments') {
            // إرسال طلب إلى صفحة الأقسام لعرض الأخبار
            fetch('departments.php')
                .then(response => response.text())
                .then(data => {
                    // هنا يمكنك عرض أو تحديث محتوى صفحة الأقسام في نموذج المسؤول إذا لزم الأمر
                    console.log('محتوى صفحة الأقسام:', data);
                });
        }
    });

    // تحديث نموذج تعديل الأخبار عند تحميل الصفحة
    fetch('admin_actions.php?action=fetch_news')
        .then(response => response.json())
        .then(data => {
            let newsList = document.getElementById('newsList');
            newsList.innerHTML = '';
            data.news.forEach(news => {
                let form = `
                    <form method="POST" action="admin_actions.php">
                        <input type="hidden" name="action" value="edit_news">
                        <input type="hidden" name="news_id" value="${news.id}">
                        <div class="mb-3">
                            <label for="news_title_${news.id}" class="form-label">عنوان الخبر</label>
                            <input type="text" class="form-control" id="news_title_${news.id}" name="news_title" value="${news.title}" required>
                        </div>
                        <div class="mb-3">
                            <label for="news_content_${news.id}" class="form-label">محتوى الخبر</label>
                            <textarea class="form-control" id="news_content_${news.id}" name="news_content" rows="4" required>${news.content}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="page_${news.id}" class="form-label">صفحة الخبر</label>
                            <select class="form-select" id="page_${news.id}" name="page" required>
                                <option value="homepage" ${news.page == 'homepage' ? 'selected' : ''}>الصفحة الرئيسية</option>
                                <option value="departments" ${news.page == 'departments' ? 'selected' : ''}>الأقسام العلمية</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">تعديل</button>
                        <button type="submit" name="action" value="delete_news" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من مسح هذا الخبر؟')">مسح</button>
                    </form>
                    <hr>
                `;
                newsList.innerHTML += form;
            });
        });
});
