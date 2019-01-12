<template>

  <div>
    <el-container>
      <el-main>

        <!-- 表单 -->
        <el-form :model="form1" style="margin-bottom: 10px; margin-top: 20px;" label-position="right" label-width="100px">
          <el-row :gutter="20">

            <el-col :span="6"><el-form-item label="账号"><el-input placeholder="会员账号" clearable/></el-form-item></el-col>

            <el-col :span="6">
              <el-form-item label="会员状态">
                <el-select v-model="form1.selectVipStatus" placeholder="会员状态" disabled>
                  <el-option
                    v-for="item in form1.optionsVipStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="会员等级">
                <el-select v-model="form1.selectVipLv" placeholder="会员等级" disabled>
                  <el-option
                    v-for="item in form1.optionsVipLv"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :span="6"><el-form-item label="上级"><el-input placeholder="上级账号" disabled/></el-form-item></el-col>

          </el-row>

          <el-row :gutter="20">

            <el-col :span="7">
              <el-form-item label="注册日期">
                <el-date-picker
                  v-model="form1.date"
                  type="daterange"
                  range-separator="~"
                  start-placeholder="开始日期"
                  end-placeholder="结束日期"
                />
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="玩家状态">
                <el-select v-model="form1.selectUserStatus" placeholder="请选择" clearable>
                  <el-option
                    v-for="item in form1.optionsUserStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :span="3"><el-form-item><el-button @click="onSubmit">更多条件</el-button></el-form-item></el-col>

            <el-col :span="3"><el-form-item><el-button @click="onSubmit">+新增</el-button></el-form-item></el-col>

            <el-col :span="3"><el-form-item><el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button></el-form-item></el-col>

          </el-row>

          <el-row :gutter="20">

            <el-col :span="6"><el-form-item label="会员ID"><el-input placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="手机号码"><el-input placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="真实姓名"><el-input placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="银行卡"><el-input placeholder="" clearable/></el-form-item></el-col>

          </el-row>

        </el-form>

        <!-- 表格 -->
        <el-table
          :data="tableData"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          stripe
          style="width: 100%; margin-bottom: 20px">
          <el-table-column min-width="10%" prop="online" label="在线" align="center"/>
          <el-table-column min-width="10%" prop="vipAccount" label="账号" align="center"/>
          <el-table-column min-width="10%" prop="vipId" label="会员id" align="center"/>
          <el-table-column min-width="10%" prop="realName" label="真实姓名" align="center"/>
          <el-table-column min-width="10%" prop="upLine" label="上级" align="center"/>
          <el-table-column min-width="10%" prop="downLineNum" label="下级人数" align="center"/>
          <el-table-column min-width="10%" prop="registerDate" label="注册日期" align="center"/>
          <el-table-column min-width="10%" prop="status" label="状态" align="center"/>
          <el-table-column min-width="10%" prop="balance" label="账户余额" align="center"/>
          <el-table-column min-width="10%" prop="userStatus" label="玩家状态" align="center"/>
          <el-table-column min-width="15%" prop="operation" label="操作" align="center">
            <template slot-scope="scope">
              <el-row :gutter="40">
                <el-col :span="6">
                  <el-button size="mini" @click="handleDetail()">详情</el-button>
                </el-col>
                <el-col :span="6">
                  <div v-if="scope.row.status==='黑名单'">
                    <el-button size="mini" type="success" @click="handleDetail()">启用</el-button>
                  </div>
                  <div v-else>
                    <el-button size="mini" type="danger" @click="handleDetail()">禁用</el-button>
                  </div>
                </el-col>
              </el-row>

            </template>
          </el-table-column>
        </el-table>

        <!-- 分页 -->
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          align="center"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  data() {
    return {

      form1: {
        selectVipStatus: '',
        selectVipLv: '',
        date: '',
        selectUserStatus: '',
        optionsVipStatus: [{
          label: '全部',
          value: 'all'
        }, {
          label: '启用',
          value: 'open'
        }, {
          label: '禁用',
          value: 'close'
        }],
        optionsVipLv: [],
        optionsUserStatus: [{
          label: '在线',
          value: 'online'
        }, {
          label: '离线',
          value: 'offline'
        }]
      },

      // tableData
      tableData: [{
        online: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        online: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage: 1
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
