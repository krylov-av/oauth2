#Как удалить директорию или файл в git
Если Вы случайно закоммитили ненужный файл или директорию в git-репозиторий и уже сделали push, 
то чтобы удалить все следы этого файла или папки в том числе и из истории, достаточно сделать следующее:
1. добавляем эту директорию или файл в .gitignore
2. git filter-branch --tree-filter "rm -rf .idea" HEAD
3. git push gh master --force
---
Source tree = software for graph access to git
