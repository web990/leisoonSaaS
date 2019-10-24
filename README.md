# leisoonSaaS

#### 介绍
LeisoonSaaS是基于thinkphp5.1开发的多租户开发框架。权限管理、用户管理、Web站点（单站点、Web集群系统）、单点登录（第三方登录）、API管理、CRM系统、流程系统、消息系统、邮件系统、日志系统等企业内部应用系统都可以基于LeisoonSaaS一套基础平台完成，避免复杂的系统维护，让程序员从此只维护一套系统。目标让开发者快速开发、易于维护的系统平台。
    系统采用前后端分离模式，LeisoonSaaS提供API接口（JWT token认证），配合[LeisoonAdmin后台管理框架](https://gitee.com/websky/leisoonAdmin)使用。
    
> 提示：本框架适合有一定基础的开发人员学习使用

## 演示系统
- LeisoonAdmin：<a target="_blank" href="http://demo.leisoon.com">http://demo.leisoon.com</a>
- 用户名：admin 密码：admin888

#### 开发环境
1. PHP >=7.0(建议7.1)
2. MySQL >5.5 (推荐5.7)
3. Apache / Nginx
4. Windows / Linux
5. 建议采用lnmp或者lamp环境

#### 使用说明

**1、composer安装依赖库和插件**
- 在命令行下面切换到应用根目录，执行下面命令 composer update

**2、导入数据库**

- 手动导入系统根目录“database”下SQL脚本文件

**3、设置web访问**

- web访问目录为public/index.php(详情请参考Thinkphp5.1官方文档)
- 提示“{"code":1010,"msg":"未登录","time":1567657873,"data":[]}”信息说明LeisoonSaaS配置成功，请配合<a href="https://gitee.com/websky/leisoonAdmin">LeisoonAdmin后台管理框架</a>使用

**4、系统文档**  
 - 开发文档 https://www.kancloud.cn/websky/leisoon_saas 
 - 文档空间地址： https://apidoc.gitee.com/websky/leisoonSaaS



## **问题反馈**

在使用中有任何问题，请使用以下联系方式联系我们

QQ群: [13942255]
<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=8bfa7fce0390385f5092ed071efc475ca91618beb969c4e76b58665dcbfc7ea1"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="LeisoonSaaS" title="LeisoonSaaS"></a>

Email: (web88#qq.com, 把#换成@)

Github: https://github.com/web990/leisoonSaaS

Gitee: https://gitee.com/websky/leisoonSaaS

LeisoonAdmin Gitee: https://gitee.com/websky/leisoonAdmin

LeisoonSaaS 文档：https://www.kancloud.cn/websky/leisoon_saas

LeisoonAdmin 文档：https://www.kancloud.cn/websky/leisoon_admin

## **特别鸣谢**

感谢以下的项目,排名不分先后?

ThinkPHP：http://www.thinkphp.cn

Layui：https://www.layui.com/

jQuery：http://jquery.com

贡献成员：Websky、小小张、小悦子、水工网孙俊、团购网邱云龙、慧慧张、3PNG张冬莉、飞翔网络杨志红等



## 版权信息

leisoonSaaS遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2008-2019 by leisoonSaaS (http://leisoon.com)

All rights reserved。

leisoonSaaS 商标和著作权所有者为安徽雷速信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)