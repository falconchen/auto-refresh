# auto-refresh

updated by bkb 

初始化
```
cd 项目根目录
#如果有src目录
git submodule add https://github.com/falconchen/auto-refresh.git src/wp-content/plugins/auto-refresh
#如果没有src目录
git submodule add https://github.com/falconchen/auto-refresh.git wp-content/plugins/auto-refresh

#克隆到其他地方开发时需要先拉取
git submodule update --init --recursive
```

更新
```
git submodule update --remote --merge
```

*** 注意：拉取submodule 更新 后主项目的代码也发生了变化，所以主项目也要执行一次 git add /commit /push ***
