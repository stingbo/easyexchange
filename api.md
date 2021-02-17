### API 接口列表

---

| 图标 | 意义 |
|:---:|:---:|
| :key: | API 有验证 |
| :question: | API 方法尚存疑问 |
| :heavy_multiplication_x: | API 接口未完成 |
| :heavy_check_mark: | API 接口已完成 |

#### 基本信息 - basic

| endpoint | 功能 |
| :---: | :---: |
| :heavy_check_mark: [systemTime](docs/systemTime.md) | 获取当前交易所时间戳 |
| :heavy_check_mark: [systemStatus](docs/systemStatus.md) | 获取当前系统状态 |
| :heavy_check_mark: [exchangeInfo](docs/exchangeInfo.md) | 获取所有交易对信息 |

#### 行情 - market

| endpoint | 功能 |
| :---: | :---: |
| :heavy_check_mark: [marketStatus](docs/marketStatus.md) | 获取当前市场状态 |
| :heavy_check_mark: [depth](docs/depth.md) | 获取交易深度 |
| :heavy_check_mark: [trades](docs/trades.md) | 获取近期成交 |
| :heavy_check_mark: [historicalTrades](docs/historicalTrades.md) | 查询历史成交 |
| :heavy_check_mark: [aggTrades](docs/aggTrades.md) | 聚合行情（Ticker） |
| :heavy_check_mark: [24hr](docs/24hr.md) | 24hr 价格变动情况 |
| :heavy_check_mark: [kline](docs/kline.md) | K 线数据 |

#### 交易接口 - trade
| endpoint | 功能 |
| :---: | :---: |
| :heavy_check_mark: [account](docs/account.md) :key: | 账户信息 |
| :heavy_check_mark: [order](docs/order.md) :key: | 下单 |
| :heavy_check_mark: [openOrders](docs/openOrders.md) :key: | 查询当前未成交订单 |
| :heavy_check_mark: [cancelOrder](docs/cancelOrder.md) :key: | 撤销订单 |
| :heavy_multiplication_x: [get](docs/get.md) :key: | 查询订单 |
