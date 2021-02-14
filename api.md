### API 接口列表
---

| 图标 | 意义 |
|:---:|---|
| :key: | API 有验证 |
| :question: | API 方法尚存疑问 |
| :heavy_multiplication_x: | API 接口未完成 |
| :heavy_check_mark: | API 接口已完成 |

#### 行情 - market

| endpoint | 功能 |
| --- | --- |
| :heavy_check_mark: [depth](depth) | 获取交易深度 |
| :heavy_check_mark: [tarde](tarde) | 获取近期成交 |
| :heavy_check_mark: [historicalTrades](historicalTrades) | 查询历史成交 |

#### 交易接口 - trade
| endpoint | 功能 |
| --- | --- |
| :heavy_check_mark: [account](account) :key: | 账户信息 |
| :heavy_check_mark: [order](order) :key: | 下单 |
| :heavy_multiplication_x: [deleteOrder](deleteOrder) :key: | 撤销订单 |
