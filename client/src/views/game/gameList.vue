<template>
  <div>
    <el-form :inline="true" :model="form1" class="demo-form-inline" align="left" style="margin-top: 30px">
      <el-form-item label="游戏名称:">
        <el-input v-model="form1.gameName"/>
      </el-form-item>
      <el-form-item label="游戏状态:">
        <el-select v-model="form1.gameStatus">
          <el-option
            v-for="item in optionsGameStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="游戏类型:">
        <el-select v-model="form1.gameType">
          <el-option
            v-for="item in optionsGameType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>
    </el-form>

    <el-table :data="tableData" stripe style="margin-bottom: 24px">
      <el-table-column label="游戏名称" prop="gameName" align="center"/>
      <el-table-column label="游戏类型" align="center">
        <template slot-scope="scope">
          <el-tag size="medium">{{ scope.row.gameType }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="游戏状态" align="center">
        <template slot-scope="scope">
          <el-tag type="success" size="medium">{{ scope.row.gameStatus }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="维护时间" prop="maintainTime" align="center"/>
      <el-table-column label="操作" prop="operation" align="center">
        <template slot-scope="scope">
          <el-button type="primary" plain size="mini" @click="handleRoom()">房间</el-button>
          <!-- <el-button size="mini" @click="dialogForm1Visible = true">编辑</el-button> -->
          <el-button size="mini" @click="handleEdit(scope.row.gameName)">编辑</el-button>
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

    <!-- dialog1 添加 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="" center>
      <el-form ref="dialogForm1" :model="dialogForm1">

        <el-form-item :label-width="dialogForm1.form1LabelWidth" label="游戏状态:">
          <el-select v-model="dialogForm1.selectStatus" placeholder="">
            <el-option
              v-for="item in dialogForm1.optionsStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="handleDialog1Save">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog>

  </div>
</template>

<script>
import { listGet } from '@/api/game'
import { listChangeStatus } from '@/api/game'

var gameName = ''
var gameType = -1
var gameStatus = -1

export default {
  data() {
    return {
      form1: {
        gameName: '',
        gameStatus: -1,
        gameType: -1
      },

      // optionsGameStatus
      optionsGameStatus: [{
        'label': '全部',
        'value': -1
      }, {
        'label': '正常',
        'value': 1
      }, {
        'label': '禁用',
        'value': 2
      }, {
        'label': '维护中',
        'value': 3
      }],

      // optionsGameType
      optionsGameType: [{
        'label': '全部',
        'value': -1
      }, {
        'label': '下注类',
        'value': 1
      }, {
        'label': '捕鱼类',
        'value': 2
      }, {
        'label': '对战类',
        'value': 3
      }],

      // tableData
      tableData: null,

      // 分页
      currentPage: 4,

      // dialog1 添加
      dialogForm1Visible: false,
      passGameName: '',
      dialogForm1: {
        form1LabelWidth: '120px',
        selectStatus: 1,
        optionsStatus: [{
          label: '正常',
          value: 1
        }, {
          label: '关闭',
          value: 2
        }, {
          label: '维护中',
          value: 3
        }]
      }
    }
  },

  created() {
    this.listGetClient(gameName, gameType, gameStatus)
  },

  methods: {
    listGetClient(gameName, gameType, gameStatus) {
      listGet(gameName, gameType, gameStatus).then(response => {
        this.tableData = response.data
      })
    },

    onSubmit() {
      console.log('name = ' + this.form1.gameName + ', type = ' + this.form1.gameType + ', status = ' + this.form1.gameStatus)
      this.listGetClient(this.form1.gameName, this.form1.gameType, this.form1.gameStatus)
    },

    // dialog1
    listChangeStatusClient(gameName, gameStatus) {
      listChangeStatus(gameName, gameStatus).then(response => {
        if (response.code === 0) {
          console.log('type = ' + typeof (gameStatus) + ', value = ' + gameStatus)
          switch (gameStatus) {
            case 1:
              this.tableData
              this.$notify({
                title: '启用游戏成功',
                message: '',
                type: 'success'
              })
              break
            case 2:
              this.$notify({
                title: '关闭游戏成功',
                message: '',
                type: 'success'
              })
              break
            case 3:
              this.$notify({
                title: '维护游戏成功',
                message: '',
                type: 'success'
              })
              break
          }
        } else {
          switch (gameStatus) {
            case 1:
              this.$notify({
                title: '启用游戏成功',
                message: '',
                type: 'error'
              })
              break
            case 2:
              this.$notify({
                title: '关闭游戏成功',
                message: '',
                type: 'error'
              })
              break
            case 3:
              this.$notify({
                title: '维护游戏成功',
                message: '',
                type: 'error'
              })
              break
          }
        }
      })
    },
    handleDialog1Save() {
      this.listChangeStatusClient(this.passGameName, this.dialogForm1.selectStatus) // todo gameName
    },
    handleEdit(gameName) {
      this.dialogForm1Visible = true
      this.passGameName = gameName
    },

    // 分页
    handleSizeChange(val) {
    },
    handleCurrentChange(val) {

    }
  }
}
</script>
