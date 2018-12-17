<template>
  <div>
    <el-container direction="vertical">
      <el-header style="text-align: left">
        选择时间区间
        <el-date-picker
          v-model="value1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
        <el-button type="primary">搜索</el-button>
        <el-button>今天</el-button>
        <el-button>昨天</el-button>
        <el-button>本周</el-button>
        <el-button>上周</el-button>
        <el-button>本月</el-button>
        <el-button>上月</el-button>
      </el-header>

      <el-row :gutter="20">
        <el-col :span="6"><div class="grid-content bg-purple"/>
          <el-card class="box-card">
            <div class="text item">
              总盈亏
            </div>
            <div class="text item">
              111.00
            </div>
            <div class="text item">
              日均盈亏
            </div>
          </el-card>
        </el-col>
        <el-col :span="6"><div class="grid-content bg-purple"/>
          <el-card class="box-card">
            <div class="text item">
              总收入额
            </div>
            <div class="text item">
              111.00
            </div>
            <div class="text item">
              日均入款额
            </div>
          </el-card>
        </el-col>
        <el-col :span="6"><div class="grid-content bg-purple"/>
          <el-card class="box-card">
            <div class="text item">
              总出款额
            </div>
            <div class="text item">
              111.00
            </div>
            <div class="text item">
              日均出款额
            </div>
          </el-card>
        </el-col>
        <el-col :span="6"><div class="grid-content bg-purple"/>
          <el-card class="box-card">
            <div class="text item">
              有效会员
            </div>
            <div class="text item">
              111人
            </div>
            <div class="text item">
              日均有效会员 2人
            </div>
          </el-card>
        </el-col>
      </el-row>

      <el-container style="height: 400px">

        <el-container>
          <el-header style="text-align: left">笔数/人数</el-header>
          <el-main>
            <el-container>
              <el-aside style="height: 300px">
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计充值笔数</el-row>
                  <el-row>7/5</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计提现笔数</el-row>
                  <el-row>7/5</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计首充笔数</el-row>
                  <el-row>7</el-row>
                </el-row>
              </el-aside>
              <el-main>

                <el-row>
                  <el-col :span="4" style="text-align: left; margin-bottom: 0px;">近期状况</el-col>
                  <el-col style="text-align: right">
                    <el-button>今日</el-button>
                    <el-button>本周</el-button>
                    <el-button>本月</el-button>
                    <el-date-picker
                      v-model="value1"
                      type="daterange"
                      range-separator="~"
                      start-placeholder="开始日期"
                      end-placeholder="结束日期"
                    />
                  </el-col>
                </el-row>

                <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
                  <line-chart :chart-data="lineChartData"/>
                </el-row>
              </el-main>
            </el-container>
          </el-main>
        </el-container>

        <el-container style="width: 100px">
          <el-header style="text-align: left">注册人数</el-header>
          <el-main>
            <el-table :data="tableData" height="300px">
              <el-table-column prop="date" label="日期" width="100"/>
              <el-table-column prop="personNum" label="人数" width="100"/>
            </el-table>
          </el-main>
        </el-container>

      </el-container>

      <el-container style="height: 400px">

        <el-container>
          <el-header style="text-align: left">充提</el-header>
          <el-main>
            <el-container>
              <el-aside>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计充值金额</el-row>
                  <el-row>111.00</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计提现金额</el-row>
                  <el-row>111.00</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计首充金额</el-row>
                  <el-row>111.00</el-row>
                </el-row>
              </el-aside>
              <el-main>
                <div style="text-align: left">
                  近期状况
                </div>
                <div style="text-align: right">
                  <el-button>今日</el-button>
                  <el-button>本周</el-button>
                  <el-button>本月</el-button>
                  <el-date-picker
                    v-model="value1"
                    type="daterange"
                    range-separator="~"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                  />

                  <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
                    <line-chart :chart-data="lineChartData"/>
                  </el-row>
                </div>
              </el-main>
            </el-container>
          </el-main>
        </el-container>

        <el-container style="width: 100px">
          <el-header style="text-align: left">游戏热度</el-header>
          <el-main>Main</el-main>
        </el-container>

      </el-container>

      <el-container style="height: 400px">

        <el-container>
          <el-header style="text-align: left">盈亏</el-header>
          <el-main>
            <el-container>
              <el-aside>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计系统盈亏</el-row>
                  <el-row>111.11</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计推广返水</el-row>
                  <el-row>1.11</el-row>
                </el-row>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计服务税收</el-row>
                  <el-row>111.11</el-row>
                </el-row>
              </el-aside>
              <el-main>
                <div style="text-align: left">
                  近期状况
                </div>
                <div style="text-align: right">
                  <el-button>今日</el-button>
                  <el-button>本周</el-button>
                  <el-button>本月</el-button>
                  <el-date-picker
                    v-model="value1"
                    type="daterange"
                    range-separator="~"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                  />

                  <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
                    <line-chart :chart-data="lineChartData"/>
                  </el-row>
                </div>
              </el-main>
            </el-container>
          </el-main>
        </el-container>

        <el-container style="width: 100px">
          <el-header style="text-align: left">流量分布</el-header>
          <el-main>Main</el-main>
        </el-container>

      </el-container>

      <el-container style="height: 400px">

        <el-container>
          <el-header style="text-align: left">在线人数</el-header>
          <el-main>
            <el-container>
              <el-aside>
                <el-row style="line-height: 20px; margin-bottom: 20px;">
                  <el-row>累计在线会员</el-row>
                  <el-row>1111</el-row>
                </el-row>
              </el-aside>
              <el-main>
                <div style="text-align: left">
                  近期状况
                </div>
                <div style="text-align: right">
                  <el-button>今日</el-button>
                  <el-button>本周</el-button>
                  <el-button>本月</el-button>
                  <el-date-picker
                    v-model="value1"
                    type="daterange"
                    range-separator="~"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                  />

                  <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
                    <line-chart :chart-data="lineChartData"/>
                  </el-row>
                </div>
              </el-main>
            </el-container>
          </el-main>
        </el-container>

        <el-container>
          <el-header>Header</el-header>
          <el-main>Main</el-main>
        </el-container>

      </el-container>

  </el-container></div></el-container>

  </div>
</template>

<script>
import LineChart from './components/LineChart'

const lineChartData = {
  newVisitis: {
    expectedData: [100, 120, 161, 134, 105, 160, 165],
    actualData: [120, 82, 91, 154, 162, 140, 145]
  },
  messages: {
    expectedData: [200, 192, 120, 144, 160, 130, 140],
    actualData: [180, 160, 151, 106, 145, 150, 130]
  },
  purchases: {
    expectedData: [80, 100, 121, 104, 105, 90, 100],
    actualData: [120, 90, 100, 138, 142, 130, 130]
  },
  shoppings: {
    expectedData: [130, 140, 141, 142, 145, 150, 160],
    actualData: [120, 82, 91, 154, 162, 140, 130]
  }
}

export default {
  name: 'DashboardAdmin',
  components: {
    LineChart
  },
  data() {
    return {
      lineChartData: lineChartData.newVisitis
    }
  },
  methods: {
    handleSetLineChartData(type) {
      this.lineChartData = lineChartData[type]
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss">
.el-header, .el-footer {
    background-color: rgb(205, 209, 179);
    color: #333;
    text-align: center;
    line-height: 60px;
  }

  .el-aside {
    // background-color: #D3DCE6;
    color: #333;
    text-align: left;
    line-height: 60px;
  }

  .el-main {
    // background-color: #E9EEF3;
    color: #333;
    text-align: center;
    // line-height: 160px;
  }

  body > .el-container {
    margin-bottom: 40px;
  }

  .el-container:nth-child(5) .el-aside,
  .el-container:nth-child(6) .el-aside {
    line-height: 260px;
  }

  .el-container:nth-child(7) .el-aside {
    line-height: 320px;
  }

  // .el-row {
  //   margin-bottom: 20px;
  //   &:last-child {
  //     margin-bottom: 0;
  //   }
  // }
  // .el-col {
  //   border-radius: 4px;
  // }

  // dashboard

</style>

